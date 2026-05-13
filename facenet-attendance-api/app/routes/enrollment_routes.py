"""
Worker enrollment routes
"""
from flask import Blueprint, request, jsonify, current_app
from app import db
from app.models.models import Worker, FaceEncoding
from app.services.facenet_service import FaceNetService
from app.services.enrollment_service import EnrollmentService
from werkzeug.utils import secure_filename
import logging
import os
from datetime import datetime

logger = logging.getLogger(__name__)

enrollment_bp = Blueprint('enrollment', __name__, url_prefix='/enroll')

# Initialize services
facenet_service = FaceNetService(
    tolerance=current_app.config.get('FACE_RECOGNITION_TOLERANCE', 0.6),
    model=current_app.config.get('FACE_RECOGNITION_MODEL', 'hog')
)
enrollment_service = EnrollmentService(facenet_service)

def allowed_file(filename):
    """Check if file has allowed extension"""
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in current_app.config.get('ALLOWED_EXTENSIONS', {'jpg', 'jpeg', 'png'})

@enrollment_bp.route('/worker', methods=['POST'])
def enroll_worker():
    """
    Enroll a new worker with face images
    
    Request multipart form-data:
        - worker_id: string (unique identifier)
        - name: string
        - email: string
        - phone: string (optional)
        - position: string (optional)
        - department: string (optional)
        - images: multiple image files
        
    Returns:
        - enrollment result with success status
    """
    try:
        # Validate required fields
        required_fields = ['worker_id', 'name', 'email']
        for field in required_fields:
            if field not in request.form:
                return jsonify({'error': f'Missing required field: {field}'}), 400
        
        worker_id = request.form.get('worker_id')
        name = request.form.get('name')
        email = request.form.get('email')
        phone = request.form.get('phone')
        position = request.form.get('position')
        department = request.form.get('department')
        
        # Check for duplicate worker
        existing = Worker.query.filter_by(worker_id=worker_id).first()
        if existing and existing.is_enrolled:
            return jsonify({'error': f'Worker {worker_id} already enrolled'}), 409
        
        # Process uploaded images
        if 'images' not in request.files:
            return jsonify({'error': 'No images provided'}), 400
        
        files = request.files.getlist('images')
        if not files or len(files) == 0:
            return jsonify({'error': 'At least one image required'}), 400
        
        # Save images temporarily
        upload_dir = current_app.config.get('UPLOAD_FOLDER')
        os.makedirs(upload_dir, exist_ok=True)
        
        image_paths = []
        for file in files:
            if file and allowed_file(file.filename):
                filename = secure_filename(f"{worker_id}_{datetime.utcnow().timestamp()}_{file.filename}")
                filepath = os.path.join(upload_dir, filename)
                file.save(filepath)
                image_paths.append(filepath)
        
        if not image_paths:
            return jsonify({'error': 'No valid image files provided'}), 400
        
        # Perform enrollment
        result = enrollment_service.enroll_worker(
            worker_id_str=worker_id,
            name=name,
            email=email,
            image_paths=image_paths,
            phone=phone,
            position=position,
            department=department
        )
        
        if result['success']:
            return jsonify({
                'success': True,
                'message': f'Worker {worker_id} enrolled successfully',
                'data': result
            }), 201
        else:
            return jsonify({
                'success': False,
                'error': 'Failed to process face images',
                'data': result
            }), 400
            
    except Exception as e:
        logger.error(f'Enrollment error: {str(e)}')
        return jsonify({'error': 'Internal server error', 'details': str(e)}), 500

@enrollment_bp.route('/worker/<worker_id>', methods=['GET'])
def get_worker_enrollment(worker_id):
    """Get enrollment status for a worker"""
    try:
        worker = Worker.query.filter_by(worker_id=worker_id).first()
        
        if not worker:
            return jsonify({'error': 'Worker not found'}), 404
        
        encodings_count = FaceEncoding.query.filter_by(worker_id=worker.id).count()
        
        return jsonify({
            'success': True,
            'worker': worker.to_dict(),
            'encodings_count': encodings_count,
            'is_enrolled': worker.is_enrolled
        }), 200
        
    except Exception as e:
        logger.error(f'Get enrollment error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500

@enrollment_bp.route('/workers', methods=['GET'])
def list_enrolled_workers():
    """List all enrolled workers"""
    try:
        page = request.args.get('page', 1, type=int)
        per_page = request.args.get('per_page', 20, type=int)
        
        paginated = Worker.query.filter_by(is_enrolled=True, active=True).paginate(
            page=page,
            per_page=per_page
        )
        
        workers = [w.to_dict() for w in paginated.items]
        
        return jsonify({
            'success': True,
            'workers': workers,
            'total': paginated.total,
            'pages': paginated.pages,
            'current_page': page
        }), 200
        
    except Exception as e:
        logger.error(f'List workers error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500
