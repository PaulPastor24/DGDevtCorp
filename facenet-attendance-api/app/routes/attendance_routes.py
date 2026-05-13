"""
Attendance records and reporting routes
"""
from flask import Blueprint, request, jsonify
from app.models.models import AttendanceRecord, Worker
from datetime import datetime, timedelta
import logging

logger = logging.getLogger(__name__)

attendance_bp = Blueprint('attendance', __name__, url_prefix='/attendance')

@attendance_bp.route('/records', methods=['GET'])
def get_attendance_records():
    """
    Get attendance records with filtering
    
    Query parameters:
        - start_date: ISO format date (YYYY-MM-DD)
        - end_date: ISO format date (YYYY-MM-DD)
        - worker_id: Filter by worker ID
        - page: Page number (default 1)
        - per_page: Records per page (default 20)
        
    Returns:
        - attendance records
        - pagination info
    """
    try:
        start_date_str = request.args.get('start_date')
        end_date_str = request.args.get('end_date')
        worker_id_str = request.args.get('worker_id')
        page = request.args.get('page', 1, type=int)
        per_page = request.args.get('per_page', 20, type=int)
        
        query = AttendanceRecord.query
        
        # Date filter
        if start_date_str:
            try:
                start_date = datetime.fromisoformat(start_date_str)
                query = query.filter(AttendanceRecord.date >= start_date.date())
            except ValueError:
                return jsonify({'error': 'Invalid start_date format'}), 400
        
        if end_date_str:
            try:
                end_date = datetime.fromisoformat(end_date_str)
                query = query.filter(AttendanceRecord.date <= end_date.date())
            except ValueError:
                return jsonify({'error': 'Invalid end_date format'}), 400
        
        # Worker filter
        if worker_id_str:
            worker = Worker.query.filter_by(worker_id=worker_id_str).first()
            if worker:
                query = query.filter(AttendanceRecord.worker_id == worker.id)
        
        # Pagination
        paginated = query.order_by(AttendanceRecord.check_in_time.desc()).paginate(
            page=page,
            per_page=per_page
        )
        
        records = [r.to_dict() for r in paginated.items]
        
        return jsonify({
            'success': True,
            'records': records,
            'pagination': {
                'total': paginated.total,
                'pages': paginated.pages,
                'current_page': page,
                'per_page': per_page
            }
        }), 200
        
    except Exception as e:
        logger.error(f'Get attendance records error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500

@attendance_bp.route('/summary/<worker_id>', methods=['GET'])
def get_attendance_summary(worker_id):
    """
    Get attendance summary for a worker
    
    Query parameters:
        - days: Number of days to look back (default 30)
        
    Returns:
        - attendance statistics
    """
    try:
        days = request.args.get('days', 30, type=int)
        
        worker = Worker.query.filter_by(worker_id=worker_id).first()
        
        if not worker:
            return jsonify({'error': 'Worker not found'}), 404
        
        start_date = datetime.utcnow() - timedelta(days=days)
        records = AttendanceRecord.query.filter(
            AttendanceRecord.worker_id == worker.id,
            AttendanceRecord.check_in_time >= start_date
        ).all()
        
        total_days = len(records)
        present_days = len([r for r in records if r.status == 'present'])
        late_days = len([r for r in records if r.status == 'late'])
        
        # Calculate average confidence
        avg_confidence = 0
        if records:
            avg_confidence = sum([r.confidence_score for r in records if r.confidence_score]) / len(records)
        
        return jsonify({
            'success': True,
            'worker': {
                'id': worker.id,
                'worker_id': worker.worker_id,
                'name': worker.name,
                'position': worker.position
            },
            'summary': {
                'period_days': days,
                'total_attendance_days': total_days,
                'present_days': present_days,
                'late_days': late_days,
                'attendance_percentage': (present_days / days * 100) if days > 0 else 0,
                'average_confidence': round(avg_confidence, 4)
            }
        }), 200
        
    except Exception as e:
        logger.error(f'Get attendance summary error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500

@attendance_bp.route('/daily-report', methods=['GET'])
def get_daily_report():
    """
    Get daily attendance report
    
    Query parameters:
        - date: ISO format date (YYYY-MM-DD), default today
        - status: Filter by status (present, late, absent)
        
    Returns:
        - attendance report for the day
    """
    try:
        date_str = request.args.get('date')
        status_filter = request.args.get('status')
        
        if date_str:
            try:
                target_date = datetime.fromisoformat(date_str).date()
            except ValueError:
                return jsonify({'error': 'Invalid date format'}), 400
        else:
            target_date = datetime.utcnow().date()
        
        query = AttendanceRecord.query.filter(AttendanceRecord.date == target_date)
        
        if status_filter:
            query = query.filter(AttendanceRecord.status == status_filter)
        
        records = query.order_by(AttendanceRecord.check_in_time.asc()).all()
        
        # Statistics
        total_present = len([r for r in records if r.status == 'present'])
        total_late = len([r for r in records if r.status == 'late'])
        total_absent = Worker.query.filter_by(active=True).count() - len(records)
        
        return jsonify({
            'success': True,
            'date': target_date.isoformat(),
            'statistics': {
                'total_present': total_present,
                'total_late': total_late,
                'total_absent': total_absent
            },
            'records': [r.to_dict() for r in records]
        }), 200
        
    except Exception as e:
        logger.error(f'Get daily report error: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500
