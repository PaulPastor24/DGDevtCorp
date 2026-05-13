"""
Main application entry point for FaceNet Attendance API
"""
from app import create_app
import os

# Create Flask application
app = create_app(os.getenv('FLASK_ENV', 'development'))

if __name__ == '__main__':
    port = int(os.getenv('API_PORT', 5000))
    debug = os.getenv('FLASK_ENV', 'development') == 'development'
    
    print(f'\n{"="*60}')
    print('FaceNet Attendance API')
    print(f'{"="*60}')
    print(f'Running on http://0.0.0.0:{port}')
    print(f'Environment: {os.getenv("FLASK_ENV", "development")}')
    print(f'{"="*60}\n')
    
    app.run(
        host='0.0.0.0',
        port=port,
        debug=debug,
        threaded=True
    )
