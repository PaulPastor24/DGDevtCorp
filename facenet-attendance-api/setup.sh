#!/bin/bash
# FaceNet Attendance API Setup Script

set -e

echo "======================================"
echo "FaceNet Attendance API - Setup Script"
echo "======================================"
echo ""

# Check Python version
python_version=$(python3 --version 2>&1 | awk '{print $2}')
echo "[✓] Python version: $python_version"

# Create virtual environment
if [ ! -d "venv" ]; then
    echo "[*] Creating virtual environment..."
    python3 -m venv venv
    echo "[✓] Virtual environment created"
else
    echo "[✓] Virtual environment already exists"
fi

# Activate virtual environment
source venv/bin/activate
echo "[✓] Virtual environment activated"

# Upgrade pip
echo "[*] Upgrading pip..."
pip install --upgrade pip wheel setuptools > /dev/null 2>&1

# Install dependencies
echo "[*] Installing Python dependencies..."
pip install -r requirements.txt > /dev/null 2>&1
echo "[✓] Dependencies installed"

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "[*] Creating .env file..."
    cp .env.example .env
    echo "[✓] .env file created - please configure it"
else
    echo "[✓] .env file already exists"
fi

# Create necessary directories
echo "[*] Creating directories..."
mkdir -p logs data/uploads data/face_encodings
echo "[✓] Directories created"

# Initialize database
echo "[*] Initializing database..."
python3 << EOF
from app import create_app, db
import os

app = create_app(os.getenv('FLASK_ENV', 'development'))
with app.app_context():
    db.create_all()
    print("[✓] Database initialized")
EOF

echo ""
echo "======================================"
echo "Setup Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Edit .env file with your configuration"
echo "2. Run: source venv/bin/activate"
echo "3. Run: python run.py"
echo ""
echo "API will be available at: http://localhost:5000"
echo "======================================"
