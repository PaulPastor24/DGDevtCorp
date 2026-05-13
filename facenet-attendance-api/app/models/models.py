"""
Database models for FaceNet Attendance System
"""
from app import db
from datetime import datetime
import json

class Worker(db.Model):
    """Worker/Employee model for face recognition"""
    __tablename__ = 'workers_facenet'
    
    id = db.Column(db.Integer, primary_key=True)
    worker_id = db.Column(db.String(50), unique=True, nullable=False, index=True)
    name = db.Column(db.String(255), nullable=False)
    email = db.Column(db.String(255), unique=True, nullable=False)
    phone = db.Column(db.String(20))
    position = db.Column(db.String(100))
    department = db.Column(db.String(100))
    
    # Face encoding status
    is_enrolled = db.Column(db.Boolean, default=False)
    enrollment_date = db.Column(db.DateTime, nullable=True)
    enrollment_images_count = db.Column(db.Integer, default=0)
    
    # Face encoding storage path
    face_encoding_path = db.Column(db.String(255), nullable=True)
    
    # Metadata
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    active = db.Column(db.Boolean, default=True)
    
    # Relationships
    attendance_records = db.relationship('AttendanceRecord', backref='worker', lazy='dynamic', cascade='all, delete-orphan')
    face_encodings = db.relationship('FaceEncoding', backref='worker', lazy='dynamic', cascade='all, delete-orphan')
    
    def __repr__(self):
        return f'<Worker {self.worker_id}: {self.name}>'
    
    def to_dict(self):
        return {
            'id': self.id,
            'worker_id': self.worker_id,
            'name': self.name,
            'email': self.email,
            'phone': self.phone,
            'position': self.position,
            'department': self.department,
            'is_enrolled': self.is_enrolled,
            'enrollment_date': self.enrollment_date.isoformat() if self.enrollment_date else None,
            'enrollment_images_count': self.enrollment_images_count,
            'created_at': self.created_at.isoformat(),
            'active': self.active
        }

class FaceEncoding(db.Model):
    """Store face encodings for each worker"""
    __tablename__ = 'face_encodings'
    
    id = db.Column(db.Integer, primary_key=True)
    worker_id = db.Column(db.Integer, db.ForeignKey('workers_facenet.id'), nullable=False, index=True)
    
    # Encoding data (stored as JSON string of numpy array)
    encoding_data = db.Column(db.Text, nullable=False)
    
    # Image metadata
    image_filename = db.Column(db.String(255))
    image_hash = db.Column(db.String(64), unique=True, index=True)
    
    # Quality metrics
    quality_score = db.Column(db.Float)  # 0-1 score
    face_landmarks = db.Column(db.Text)  # JSON of face landmarks
    
    created_at = db.Column(db.DateTime, default=datetime.utcnow, index=True)
    is_primary = db.Column(db.Boolean, default=False)  # Primary encoding for matching
    
    def __repr__(self):
        return f'<FaceEncoding for worker_id {self.worker_id}>'

class AttendanceRecord(db.Model):
    """Attendance records from face recognition"""
    __tablename__ = 'attendance_records_facenet'
    
    id = db.Column(db.Integer, primary_key=True)
    worker_id = db.Column(db.Integer, db.ForeignKey('workers_facenet.id'), nullable=False, index=True)
    
    # Attendance details
    check_in_time = db.Column(db.DateTime, nullable=False, index=True)
    check_out_time = db.Column(db.DateTime, nullable=True)
    date = db.Column(db.Date, default=datetime.utcnow, index=True)
    
    # Recognition details
    confidence_score = db.Column(db.Float)  # Matching confidence
    face_distance = db.Column(db.Float)  # Distance metric
    
    # Images
    checkin_image_path = db.Column(db.String(255))
    checkout_image_path = db.Column(db.String(255))
    
    # Status
    status = db.Column(db.String(50), default='present')  # present, late, absent, checkout
    notes = db.Column(db.Text)
    
    # Metadata
    device_id = db.Column(db.String(100))
    location = db.Column(db.String(255))
    ip_address = db.Column(db.String(50))
    
    created_at = db.Column(db.DateTime, default=datetime.utcnow)
    updated_at = db.Column(db.DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    def __repr__(self):
        return f'<Attendance {self.worker_id} on {self.date}>'
    
    def to_dict(self):
        worker = self.worker
        return {
            'id': self.id,
            'worker': {
                'id': worker.id,
                'worker_id': worker.worker_id,
                'name': worker.name,
                'position': worker.position
            },
            'check_in_time': self.check_in_time.isoformat() if self.check_in_time else None,
            'check_out_time': self.check_out_time.isoformat() if self.check_out_time else None,
            'date': self.date.isoformat(),
            'confidence_score': round(self.confidence_score, 4) if self.confidence_score else None,
            'face_distance': round(self.face_distance, 4) if self.face_distance else None,
            'status': self.status,
            'notes': self.notes,
            'device_id': self.device_id,
            'location': self.location,
            'created_at': self.created_at.isoformat()
        }

class RecognitionLog(db.Model):
    """Detailed logging of all recognition attempts"""
    __tablename__ = 'recognition_logs'
    
    id = db.Column(db.Integer, primary_key=True)
    
    # Attempt details
    attempt_timestamp = db.Column(db.DateTime, default=datetime.utcnow, index=True)
    success = db.Column(db.Boolean, default=False, index=True)
    
    # Recognition results
    worker_id = db.Column(db.Integer, db.ForeignKey('workers_facenet.id'), nullable=True)
    matched_worker_id = db.Column(db.String(50), nullable=True)
    confidence_score = db.Column(db.Float)
    
    # Image information
    image_path = db.Column(db.String(255))
    image_hash = db.Column(db.String(64))
    
    # Debug info
    processing_time_ms = db.Column(db.Float)
    error_message = db.Column(db.Text)
    
    # Context
    device_id = db.Column(db.String(100))
    location = db.Column(db.String(255))
    ip_address = db.Column(db.String(50))
    
    def __repr__(self):
        return f'<RecognitionLog {self.attempt_timestamp}>'
