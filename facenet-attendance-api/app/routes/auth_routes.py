"""
Authentication routes
"""
from flask import Blueprint, request, jsonify, current_app
import jwt
from datetime import datetime, timedelta
import logging

logger = logging.getLogger(__name__)

auth_bp = Blueprint('auth', __name__, url_prefix='/auth')

@auth_bp.route('/health', methods=['GET'])
def health_check():
    """API health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'FaceNet Attendance API',
        'timestamp': datetime.utcnow().isoformat(),
        'version': '1.0.0'
    }), 200

@auth_bp.route('/token', methods=['POST'])
def get_token():
    """
    Generate JWT token for API access
    
    Request body:
        - username: string
        - password: string
        
    Returns:
        - token: JWT token
        - expires_in: Seconds until expiration
    """
    try:
        data = request.get_json()
        
        if not data or not data.get('username') or not data.get('password'):
            return jsonify({'error': 'Missing username or password'}), 400
        
        # Simple demo authentication (replace with actual DB lookup)
        if data['username'] == 'admin' and data['password'] == 'admin123':
            payload = {
                'username': data['username'],
                'exp': datetime.utcnow() + timedelta(hours=1),
                'iat': datetime.utcnow()
            }
            
            token = jwt.encode(
                payload,
                current_app.config['JWT_SECRET'],
                algorithm='HS256'
            )
            
            return jsonify({
                'success': True,
                'token': token,
                'expires_in': 3600,
                'token_type': 'Bearer'
            }), 200
        else:
            return jsonify({'error': 'Invalid credentials'}), 401
            
    except Exception as e:
        logger.error(f'Token generation failed: {str(e)}')
        return jsonify({'error': 'Internal server error'}), 500

def verify_token(token: str) -> bool:
    """Verify JWT token"""
    try:
        jwt.decode(token, current_app.config['JWT_SECRET'], algorithms=['HS256'])
        return True
    except:
        return False
