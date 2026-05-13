"""
D&G ConstructMonitor - FaceNet Attendance API
Core application factory
"""
from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_cors import CORS
import logging
from logging.handlers import RotatingFileHandler
import os
from datetime import datetime

db = SQLAlchemy()

def create_app(config_name='production'):
    """
    Application factory pattern
    """
    app = Flask(__name__)
    
    # Load configuration
    from app.config.settings import config
    app.config.from_object(config[config_name])
    
    # Initialize extensions
    db.init_app(app)
    CORS(app, resources={r"/api/*": {"origins": app.config.get('CORS_ORIGINS', '*')}})
    
    # Setup logging
    setup_logging(app)
    
    # Register blueprints
    from app.routes import api_bp
    app.register_blueprint(api_bp, url_prefix='/api/v1')
    
    # Health check endpoint
    @app.route('/health', methods=['GET'])
    def health_check():
        return {
            'status': 'healthy',
            'service': 'FaceNet Attendance API',
            'timestamp': datetime.utcnow().isoformat()
        }, 200
    
    # Create database tables
    with app.app_context():
        db.create_all()
    
    app.logger.info('FaceNet Attendance API initialized')
    return app

def setup_logging(app):
    """
    Configure application logging
    """
    if not os.path.exists('logs'):
        os.mkdir('logs')
    
    file_handler = RotatingFileHandler(
        'logs/facenet_api.log',
        maxBytes=10485760,
        backupCount=10
    )
    
    formatter = logging.Formatter(
        '%(asctime)s - %(name)s - %(levelname)s - %(message)s',
        datefmt='%Y-%m-%d %H:%M:%S'
    )
    
    file_handler.setFormatter(formatter)
    file_handler.setLevel(logging.INFO)
    
    app.logger.addHandler(file_handler)
    app.logger.setLevel(logging.INFO)
    
    # Log startup
    app.logger.info('='*50)
    app.logger.info('FaceNet Attendance API Starting')
    app.logger.info('='*50)
