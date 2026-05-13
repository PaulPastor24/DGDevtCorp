"""
Attendance service for managing attendance records
"""
from app import db
from app.models.models import AttendanceRecord, Worker, FaceEncoding, RecognitionLog
from datetime import datetime, timedelta
from typing import Optional, Dict, List
import logging

logger = logging.getLogger(__name__)

class AttendanceService:
    """Service for attendance record management"""
    
    @staticmethod
    def record_checkin(worker_id: int, confidence_score: float, face_distance: float,
                      checkin_image_path: str, device_id: str = None, 
                      location: str = None, ip_address: str = None, notes: str = None) -> AttendanceRecord:
        """
        Record check-in for a worker
        
        Args:
            worker_id: Database worker ID
            confidence_score: Face matching confidence (0-1)
            face_distance: Face distance metric
            checkin_image_path: Path to check-in image
            device_id: Device/camera ID
            location: Check-in location
            ip_address: Client IP address
            notes: Additional notes
            
        Returns:
            AttendanceRecord object
        """
        try:
            # Check if record already exists for today
            today = datetime.utcnow().date()
            existing = AttendanceRecord.query.filter(
                AttendanceRecord.worker_id == worker_id,
                AttendanceRecord.date == today
            ).first()
            
            if existing:
                logger.info(f'Attendance already recorded for worker {worker_id} today')
                return existing
            
            record = AttendanceRecord(
                worker_id=worker_id,
                check_in_time=datetime.utcnow(),
                date=today,
                confidence_score=confidence_score,
                face_distance=face_distance,
                checkin_image_path=checkin_image_path,
                status='present',
                device_id=device_id,
                location=location,
                ip_address=ip_address,
                notes=notes
            )
            
            db.session.add(record)
            db.session.commit()
            
            logger.info(f'Check-in recorded for worker {worker_id}')
            return record
            
        except Exception as e:
            logger.error(f'Failed to record check-in: {str(e)}')
            db.session.rollback()
            raise
    
    @staticmethod
    def record_checkout(worker_id: int, checkout_image_path: str = None) -> Optional[AttendanceRecord]:
        """
        Record check-out for a worker
        
        Args:
            worker_id: Database worker ID
            checkout_image_path: Path to check-out image
            
        Returns:
            Updated AttendanceRecord or None
        """
        try:
            today = datetime.utcnow().date()
            record = AttendanceRecord.query.filter(
                AttendanceRecord.worker_id == worker_id,
                AttendanceRecord.date == today,
                AttendanceRecord.check_out_time == None
            ).first()
            
            if not record:
                logger.warning(f'No open attendance record for worker {worker_id}')
                return None
            
            record.check_out_time = datetime.utcnow()
            record.checkout_image_path = checkout_image_path
            record.updated_at = datetime.utcnow()
            
            db.session.commit()
            logger.info(f'Check-out recorded for worker {worker_id}')
            return record
            
        except Exception as e:
            logger.error(f'Failed to record check-out: {str(e)}')
            db.session.rollback()
            raise
    
    @staticmethod
    def get_attendance_by_date_range(start_date: datetime, end_date: datetime,
                                    worker_id: int = None) -> List[AttendanceRecord]:
        """
        Get attendance records for date range
        
        Args:
            start_date: Start date
            end_date: End date
            worker_id: Optional worker filter
            
        Returns:
            List of AttendanceRecord objects
        """
        query = AttendanceRecord.query.filter(
            AttendanceRecord.date >= start_date.date(),
            AttendanceRecord.date <= end_date.date()
        )
        
        if worker_id:
            query = query.filter(AttendanceRecord.worker_id == worker_id)
        
        return query.order_by(AttendanceRecord.check_in_time.desc()).all()
    
    @staticmethod
    def get_worker_attendance_summary(worker_id: int, days: int = 30) -> Dict:
        """
        Get attendance summary for a worker
        
        Args:
            worker_id: Worker ID
            days: Number of days to look back
            
        Returns:
            Dict with attendance summary
        """
        try:
            start_date = datetime.utcnow() - timedelta(days=days)
            records = AttendanceRecord.query.filter(
                AttendanceRecord.worker_id == worker_id,
                AttendanceRecord.check_in_time >= start_date
            ).all()
            
            total_days = len(records)
            present_days = len([r for r in records if r.status == 'present'])
            late_days = len([r for r in records if r.status == 'late'])
            absent_days = len([r for r in records if r.status == 'absent'])
            
            worker = Worker.query.get(worker_id)
            
            return {
                'worker_id': worker.worker_id if worker else None,
                'worker_name': worker.name if worker else None,
                'period_days': days,
                'total_records': total_days,
                'present_days': present_days,
                'late_days': late_days,
                'absent_days': absent_days,
                'attendance_percentage': (present_days / days * 100) if days > 0 else 0,
                'average_confidence': np.mean([r.confidence_score for r in records if r.confidence_score]) if records else 0
            }
            
        except Exception as e:
            logger.error(f'Failed to get attendance summary: {str(e)}')
            raise
