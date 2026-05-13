"""
Worker enrollment service for FaceNet registration
"""
from app import db
from app.models.models import Worker, FaceEncoding
from app.services.facenet_service import FaceNetService
from datetime import datetime
from pathlib import Path
import logging
from typing import List, Optional, Dict

logger = logging.getLogger(__name__)

class EnrollmentService:
    """Service for worker face enrollment"""
    
    def __init__(self, facenet_service: FaceNetService):
        self.facenet = facenet_service
    
    def enroll_worker(self, worker_id_str: str, name: str, email: str,
                     image_paths: List[str], phone: str = None,
                     position: str = None, department: str = None) -> Dict:
        """
        Enroll a new worker with face images
        
        Args:
            worker_id_str: Worker ID string
            name: Worker name
            email: Worker email
            image_paths: List of face image paths
            phone: Phone number
            position: Job position
            department: Department
            
        Returns:
            Dict with enrollment result
        """
        try:
            # Check if worker exists
            worker = Worker.query.filter_by(worker_id=worker_id_str).first()
            
            if not worker:
                worker = Worker(
                    worker_id=worker_id_str,
                    name=name,
                    email=email,
                    phone=phone,
                    position=position,
                    department=department
                )
                db.session.add(worker)
                db.session.flush()
                logger.info(f'New worker created: {worker_id_str}')
            else:
                logger.info(f'Updating worker: {worker_id_str}')
            
            # Process face images
            successful_encodings = 0
            failed_images = []
            encodings_list = []
            
            for image_path in image_paths:
                try:
                    encoding = self.facenet.encode_face_from_image(image_path)
                    
                    if encoding is None:
                        failed_images.append(image_path)
                        continue
                    
                    # Get image hash
                    image_hash = self.facenet.get_image_hash(image_path)
                    
                    # Check if encoding already exists
                    existing = FaceEncoding.query.filter_by(image_hash=image_hash).first()
                    if existing:
                        logger.warning(f'Duplicate image hash: {image_hash}')
                        continue
                    
                    # Save encoding to database
                    face_enc = FaceEncoding(
                        worker_id=worker.id,
                        encoding_data=encoding.tobytes().hex(),  # Convert to hex for storage
                        image_filename=Path(image_path).name,
                        image_hash=image_hash,
                        quality_score=0.8,  # Default quality
                        is_primary=(successful_encodings == 0)  # First is primary
                    )
                    
                    db.session.add(face_enc)
                    encodings_list.append(encoding)
                    successful_encodings += 1
                    logger.debug(f'Encoding processed for {image_path}')
                    
                except Exception as e:
                    logger.error(f'Failed to process image {image_path}: {str(e)}')
                    failed_images.append(image_path)
            
            # Update worker enrollment status
            if successful_encodings > 0:
                worker.is_enrolled = True
                worker.enrollment_date = datetime.utcnow()
                worker.enrollment_images_count = successful_encodings
                db.session.commit()
                logger.info(f'Worker {worker_id_str} enrolled successfully with {successful_encodings} images')
            else:
                db.session.rollback()
                logger.error(f'Failed to enroll worker {worker_id_str}: no valid images')
            
            return {
                'success': successful_encodings > 0,
                'worker_id': worker.worker_id,
                'worker_name': worker.name,
                'successful_encodings': successful_encodings,
                'failed_images': failed_images,
                'enrollment_date': worker.enrollment_date.isoformat() if worker.enrollment_date else None
            }
            
        except Exception as e:
            logger.error(f'Enrollment failed for {worker_id_str}: {str(e)}')
            db.session.rollback()
            raise
    
    def get_worker_encodings(self, worker_id: int) -> List[bytes]:
        """
        Get all encodings for a worker
        
        Args:
            worker_id: Database worker ID
            
        Returns:
            List of encoding bytes
        """
        encodings = FaceEncoding.query.filter_by(worker_id=worker_id).all()
        return [bytes.fromhex(enc.encoding_data) for enc in encodings]
    
    def get_primary_encoding(self, worker_id: int) -> Optional[bytes]:
        """
        Get primary encoding for a worker
        
        Args:
            worker_id: Database worker ID
            
        Returns:
            Primary encoding or None
        """
        encoding = FaceEncoding.query.filter_by(
            worker_id=worker_id,
            is_primary=True
        ).first()
        
        if encoding:
            return bytes.fromhex(encoding.encoding_data)
        return None
