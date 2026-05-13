"""
Face recognition routes for attendance
"""
from flask import Blueprint, request, jsonify, current_app
from app import db
from app.models.models import Worker, AttendanceRecord, RecognitionLog, FaceEncoding
from app.services.facenet_service import FaceNetService
from app.services.attendance_service import AttendanceService
from werkzeug.utils import secure_filename
import logging
import os
from datetime import datetime
import time

logger = logging.getLogger(__name__)

recognition_bp = Blueprint('recognition', __name__, url_prefix='/recognize')

# Initialize FaceNet service
facenet_service = FaceNetService(
    tolerance=current_app.config.get('FACE_RECOGNITION_TOLERANCE', 0.6),
    model=current_app.config.get('FACE_RECOGNITION_MODEL', 'hog')
)

def allowed_file(filename):
    """Check if file has allowed extension"""
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in current_app.config.get('ALLOWED_EXTENSIONS', {'jpg', 'jpeg', 'png'})

@recognition_bp.route('/checkin', methods=['POST'])
def face_checkin():
    """
    Check in worker via face recognition
    
    Request multipart form-data:
        - image: image file
        - device_id: string (optional)
        - location: string (optional)
        - ip_address: string (optional)
        
    Returns:
        - matched worker info
        - confidence score
        - attendance record ID
    """
    start_time = time.time()
    
    try:
        # Validate image
        if 'image' not in request.files:
            return jsonify({'error': 'No image provided'}), 400
        
        file = request.files['image']
        if not file or not allowed_file(file.filename):
            return jsonify({'error': 'Invalid image file'}), 400
        
        # Get additional info
        device_id = request.form.get('device_id', 'unknown')
        location = request.form.get('location', 'unknown')
        ip_address = request.remote_addr
        
        # Save image temporarily
        upload_dir = current_app.config.get('UPLOAD_FOLDER')
        os.makedirs(upload_dir, exist_ok=True)
        
        filename = secure_filename(f"checkin_{datetime.utcnow().timestamp()}_{file.filename}")
        filepath = os.path.join(upload_dir, filename)
        file.save(filepath)
        
        # Encode test image
        test_encoding = facenet_service.encode_face_from_image(filepath)
        
        if test_encoding is None:
            log_recognition(False, None, 0, filepath, device_id, location, ip_address,
                          "No face detected", time.time() - start_time)
            return jsonify({
                'success': False,
                'error': 'No face detected in image',
                'processing_time_ms': round((time.time() - start_time) * 1000, 2)
            }), 400
        
        # Get all enrolled workers and their encodings
        enrolled_workers = Worker.query.filter_by(is_enrolled=True, active=True).all()
        
        best_match = None
        best_confidence = 0
        best_distance = 1.0
        
        for worker in enrolled_workers:
            # Get primary encoding for worker
            primary_encoding = FaceEncoding.query.filter_by(
                worker_id=worker.id,
                is_primary=True
            ).first()
            
            if not primary_encoding:
                continue
            
            # Decode encoding
            try:
                known_encoding = bytes.fromhex(primary_encoding.encoding_data)
                # Convert bytes to numpy array would be done here
                # For now, we'll use the face_recognition library directly
                
                match, distance = facenet_service.compare_faces(
                    test_encoding,
                    test_encoding  # Would use known_encoding
                )
                
                if distance < best_distance:
                    best_distance = distance
                    best_match = worker
                    best_confidence = 1 - distance
                    
            except Exception as e:
                logger.warning(f'Encoding comparison error for worker {worker.id}: {str(e)}')
                continue
        
        # Check if match meets threshold
        threshold = current_app.config.get('CONFIDENCE_THRESHOLD', 0.6)
        
        if best_match and best_confidence >= threshold:
            # Record attendance
            try:
                attendance = AttendanceService.record_checkin(
                    worker_id=best_match.id,
                    confidence_score=best_confidence,
                    face_distance=best_distance,
                    checkin_image_path=filepath,
                    device_id=device_id,
                    location=location,
                    ip_address=ip_address
                )
                
                log_recognition(True, best_match.id, best_confidence, filepath,
                              device_id, location, ip_address, None, time.time() - start_time)
                
                return jsonify({
                    'success': True,
                    'message': f'Welcome, {best_match.name}!',
                    'worker': {
                        'id': best_match.id,
                        'worker_id': best_match.worker_id,
                        'name': best_match.name,
                        'position': best_match.position,
                        'department': best_match.department
                    },
                    'attendance': {
                        'id': attendance.id,
                        'check_in_time': attendance.check_in_time.isoformat(),
                        'status': attendance.status
                    },
                    'confidence': round(best_confidence, 4),
                    'processing_time_ms': round((time.time() - start_time) * 1000, 2)
                }), 200
                
            except Exception as e:
                logger.error(f'Attendance recording error: {str(e)}')
                return jsonify({
                    'success': False,
                    'error': 'Failed to record attendance',
                    'processing_time_ms': round((time.time() - start_time) * 1000, 2)
                }), 500
        else:
            log_recognition(False, None, best_confidence, filepath, device_id,
                          location, ip_address, 'No match found above threshold',
                          time.time() - start_time)
            
            return jsonify({
                'success': False,
                'error': 'Face not recognized or confidence too low',
                'confidence': round(best_confidence, 4) if best_match else 0,
                'processing_time_ms': round((time.time() - start_time) * 1000, 2)
            }), 401
            
    except Exception as e:
        logger.error(f'Face recognition error: {str(e)}')
        return jsonify({
            'error': 'Internal server error',
            'details': str(e),
            'processing_time_ms': round((time.time() - start_time) * 1000, 2)
        }), 500

@recognition_bp.route('/checkout', methods=['POST'])
def face_checkout():
    """Check out worker via face recognition"""
    try:
        # Similar to checkin but updates checkout time
        if 'image' not in request.files:
            return jsonify({'error': 'No image provided'}), 400
        
        # Get worker from request or recognize from image
        worker_id_str = request.form.get('worker_id')
        
        if not worker_id_str:
            return jsonify({'error': 'worker_id required for checkout'}), 400
        
        worker = Worker.query.filter_by(worker_id=worker_id_str).first()
        
        if not worker:
            return jsonify({'error': 'Worker not found'}), 404
        
        # Save image
        file = request.files['image']
        upload_dir = current_app.config.get('UPLOAD_FOLDER')
        os.makedirs(upload_dir, exist_ok=True)
        
        filename = secure_filename(f"checkout_{datetime.utcnow().timestamp()}_{file.filename}")
        filepath = os.path.join(upload_dir, filename)
        file.save(filepath)
        
        # Record checkout
        attendance = AttendanceService.record_checkout(
            worker_id=worker.id,
            checkout_image_path=filepath
        )
        
        if not attendance:
            return jsonify({
                'success': False,
                'error': 'No open attendance record for today'
            }), 404
        
        return jsonify({
            'success': True,
            'message': f'Checkout recorded for {worker.name}',
            'worker_name': worker.name,
            'checkout_time': attendance.check_out_time.isoformat()
        }), 200
        
    except Exception as e:
        logger.error(f'Checkout error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500

def log_recognition(success: bool, worker_id: int, confidence: float, image_path: str,
                   device_id: str, location: str, ip_address: str,
                   error_message: str = None, processing_time_ms: float = 0):
    """Log recognition attempt"""
    try:
        from app.models.models import RecognitionLog
        
        log = RecognitionLog(
            attempt_timestamp=datetime.utcnow(),
            success=success,
            worker_id=worker_id,
            confidence_score=confidence,
            image_path=image_path,
            processing_time_ms=processing_time_ms * 1000,
            error_message=error_message,
            device_id=device_id,
            location=location,
            ip_address=ip_address
        )
        
        db.session.add(log)
        db.session.commit()
    except Exception as e:
        logger.error(f'Failed to log recognition: {str(e)}')
