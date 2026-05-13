"""
API Blueprint for FaceNet Attendance System
"""
from flask import Blueprint

api_bp = Blueprint('api', __name__)

# Import routes
from app.routes import auth_routes, enrollment_routes, recognition_routes, attendance_routes

# Register sub-blueprints
api_bp.register_blueprint(auth_routes.auth_bp)
api_bp.register_blueprint(enrollment_routes.enrollment_bp)
api_bp.register_blueprint(recognition_routes.recognition_bp)
api_bp.register_blueprint(attendance_routes.attendance_bp)
