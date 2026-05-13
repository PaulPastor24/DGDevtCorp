@echo off
REM FaceNet Attendance API Setup Script for Windows

echo ======================================
echo FaceNet Attendance API - Setup Script
echo ======================================
echo.

REM Check Python version
python --version
echo [+] Python found

REM Create virtual environment
if not exist "venv" (
    echo [*] Creating virtual environment...
    python -m venv venv
    echo [+] Virtual environment created
) else (
    echo [+] Virtual environment already exists
)

REM Activate virtual environment
call venv\Scripts\activate.bat
echo [+] Virtual environment activated

REM Upgrade pip
echo [*] Upgrading pip...
python -m pip install --upgrade pip wheel setuptools > nul 2>&1

REM Install dependencies
echo [*] Installing Python dependencies...
pip install -r requirements.txt > nul 2>&1
echo [+] Dependencies installed

REM Create .env file if it doesn't exist
if not exist ".env" (
    echo [*] Creating .env file...
    copy .env.example .env
    echo [+] .env file created - please configure it
) else (
    echo [+] .env file already exists
)

REM Create necessary directories
echo [*] Creating directories...
if not exist logs mkdir logs
if not exist data mkdir data
if not exist data\uploads mkdir data\uploads
if not exist data\face_encodings mkdir data\face_encodings
echo [+] Directories created

REM Initialize database
echo [*] Initializing database...
python << EOF
from app import create_app, db
import os

app = create_app(os.getenv('FLASK_ENV', 'development'))
with app.app_context():
    db.create_all()
    print("[+] Database initialized")
EOF

echo.
echo ======================================
echo Setup Complete!
echo ======================================
echo.
echo Next steps:
echo 1. Edit .env file with your configuration
echo 2. Run: venv\Scripts\activate.bat
echo 3. Run: python run.py
echo.
echo API will be available at: http://localhost:5000
echo ======================================
pause
