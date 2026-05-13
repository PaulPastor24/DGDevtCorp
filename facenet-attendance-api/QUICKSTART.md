# FaceNet Attendance System - Quick Start Checklist

## Pre-Deployment Checklist ✓

### System Requirements
- [ ] Python 3.8+ installed
- [ ] MySQL 5.7+ installed and running
- [ ] 2GB RAM minimum
- [ ] Disk space: 5GB (for models and data)
- [ ] Network: Open port 5000 for API

### Required Files Present
- [ ] `requirements.txt` - ✓ Present
- [ ] `.env.example` - ✓ Present
- [ ] `run.py` - ✓ Present
- [ ] `Dockerfile` - ✓ Present
- [ ] `docker-compose.yml` - ✓ Present
- [ ] `setup.sh` and `setup.bat` - ✓ Present

---

## Installation Steps

### Windows Users

1. **Open PowerShell/CMD in project directory**
   ```
   cd facenet-attendance-api
   ```

2. **Run setup script**
   ```
   setup.bat
   ```

3. **Configure environment**
   ```
   Edit .env file with your database credentials
   ```

4. **Activate environment**
   ```
   venv\Scripts\activate.bat
   ```

5. **Start API**
   ```
   python run.py
   ```

**Total Time**: ~5-10 minutes

---

### Linux/Mac Users

1. **Navigate to directory**
   ```bash
   cd facenet-attendance-api
   ```

2. **Run setup script**
   ```bash
   bash setup.sh
   ```

3. **Configure environment**
   ```bash
   nano .env  # or your preferred editor
   ```

4. **Activate environment**
   ```bash
   source venv/bin/activate
   ```

5. **Start API**
   ```bash
   python run.py
   ```

**Total Time**: ~5-10 minutes

---

### Docker Users

1. **Build and run**
   ```bash
   docker-compose up -d
   ```

2. **Verify running**
   ```bash
   docker-compose ps
   docker-compose logs facenet-api
   ```

3. **Test API**
   ```bash
   curl http://localhost:5000/health
   ```

**Total Time**: ~5 minutes (after Docker installation)

---

## Post-Installation Verification

### 1. Health Check
```bash
curl http://localhost:5000/health
```

**Expected Response:**
```json
{
  "status": "healthy",
  "service": "FaceNet Attendance API",
  "timestamp": "2024-01-15T10:30:00.000000",
  "version": "1.0.0"
}
```

### 2. Database Connection
Check `logs/facenet_api.log` for:
```
[INFO] Database connected successfully
```

### 3. Test Enrollment

```bash
curl -X POST http://localhost:5000/api/v1/enroll/worker \
  -F "worker_id=TEST001" \
  -F "name=Test User" \
  -F "email=test@example.com" \
  -F "images=@sample_photo.jpg"
```

---

## Configuration Guide

### .env File Parameters

**Critical (must set)**
```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=dg_construct_monitor
```

**Recommended**
```env
FLASK_ENV=development  # production for live
CONFIDENCE_THRESHOLD=0.6  # Lower = stricter matching
FACE_RECOGNITION_TOLERANCE=0.6  # 0.3-0.8 range
```

**Optional**
```env
API_PORT=5000  # Change if port conflicts
MAX_WORKERS=4  # For concurrent processing
LOG_LEVEL=INFO  # DEBUG for verbose logging
```

---

## Integration with PHP System

### 1. Copy Client Library
```bash
cp attendance_api_client.php /path/to/php/project/
```

### 2. Use in PHP Code
```php
<?php
require 'attendance_api_client.php';

$facenet = new FaceNetAttendanceClient('http://localhost:5000');

// Enroll worker
$result = $facenet->enrollWorker([
    'worker_id' => 'EMP001',
    'name' => 'Juan Dela Cruz',
    'email' => 'juan@example.com'
], ['photo1.jpg', 'photo2.jpg', 'photo3.jpg']);

// Check-in via face
$checkin = $facenet->checkinWorker('webcam_capture.jpg');
?>
```

### 3. Create Integration Page
Create `admin/facenet_attendance.php` in your PHP project

See `INTEGRATION_GUIDE.md` for detailed examples

---

## Testing the API

### Using cURL

**Get Token**
```bash
curl -X POST http://localhost:5000/api/v1/auth/token \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"admin123"}'
```

**Enroll Worker**
```bash
curl -X POST http://localhost:5000/api/v1/enroll/worker \
  -H "Authorization: Bearer <token>" \
  -F "worker_id=EMP001" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "images=@photo.jpg"
```

**Check-in**
```bash
curl -X POST http://localhost:5000/api/v1/recognize/checkin \
  -H "Authorization: Bearer <token>" \
  -F "image=@face_photo.jpg"
```

**Get Daily Report**
```bash
curl "http://localhost:5000/api/v1/attendance/daily-report?date=2024-01-15" \
  -H "Authorization: Bearer <token>"
```

### Using Postman

1. Import the API endpoints
2. Add Authorization header (Bearer token)
3. Test each endpoint
4. Save as collection for reuse

---

## Troubleshooting

### Issue: Port 5000 Already in Use
**Solution**: Change port in .env
```env
API_PORT=5001
```

### Issue: Database Connection Refused
**Solution**: Verify credentials
```bash
# Test MySQL connection
mysql -h localhost -u root -p -e "SHOW DATABASES;"
```

### Issue: No Faces Detected in Image
**Solution**: 
- Ensure image is clear and well-lit
- Face should be frontal, minimum 50x50 pixels
- Try different image formats (JPG, PNG)

### Issue: Low Recognition Accuracy
**Solution**:
- Enroll with 3+ high-quality images
- Ensure consistent lighting during enrollment
- Adjust CONFIDENCE_THRESHOLD in .env (lower = stricter)

### Issue: Module Not Found Errors
**Solution**:
```bash
# Reinstall dependencies
pip install --upgrade -r requirements.txt
```

### Issue: Docker Build Fails
**Solution**:
```bash
# Clean build
docker-compose down
docker system prune -a
docker-compose up -d --build
```

---

## Documentation Navigation

### For Quick Start
→ Read **README.md** (5 min read)

### For PHP Integration
→ Read **INTEGRATION_GUIDE.md** (15 min read)
→ Copy **attendance_api_client.php**
→ Follow PHP examples

### For Technical Details
→ Read **ARCHITECTURE.md** (20 min read)
→ Review database schema
→ Study API endpoints

### For Capstone Presentation
→ Read **PROJECT_SUMMARY.md** (10 min read)
→ Use provided talking points
→ Follow demo script

### For Complete Overview
→ Read **FILE_STRUCTURE.md** (5 min read)
→ See code organization
→ Review statistics

---

## Development Commands

### Start API
```bash
python run.py
```

### Run Tests
```bash
pytest tests/
```

### View Logs
```bash
tail -f logs/facenet_api.log
```

### Database Operations
```bash
# Create tables
python -c "from app import create_app, db; app = create_app(); db.create_all()"

# Check database
mysql -u root -p dg_construct_monitor -e "SHOW TABLES;"
```

### API Testing
```bash
# Health check
curl http://localhost:5000/health

# List enrolled workers
curl http://localhost:5000/api/v1/enroll/workers
```

---

## Production Deployment Checklist

Before going live:

- [ ] Change FLASK_ENV to 'production'
- [ ] Set strong SECRET_KEY in .env
- [ ] Configure HTTPS/TLS
- [ ] Set up database backups
- [ ] Enable monitoring and alerts
- [ ] Configure rate limiting
- [ ] Review security settings
- [ ] Load test the system
- [ ] Document API credentials
- [ ] Plan disaster recovery

---

## Support & Resources

### Internal Documentation
- `README.md` - Quick start
- `INTEGRATION_GUIDE.md` - PHP integration
- `ARCHITECTURE.md` - Technical details
- `PROJECT_SUMMARY.md` - Overview
- `FILE_STRUCTURE.md` - File organization

### External Resources
- [face_recognition docs](https://github.com/ageitgey/face_recognition)
- [Flask docs](https://flask.palletsprojects.com/)
- [SQLAlchemy docs](https://docs.sqlalchemy.org/)
- [Docker docs](https://docs.docker.com/)

### Getting Help
1. Check logs: `logs/facenet_api.log`
2. Review error message carefully
3. Search documentation
4. Check troubleshooting section above
5. Contact: info@dg-corp.ph

---

## Next Steps

### Immediate (Day 1)
- [ ] Install system
- [ ] Verify health check
- [ ] Test enrollment with sample images
- [ ] Test check-in/check-out

### Short-term (Week 1)
- [ ] Integrate with PHP system
- [ ] Create admin dashboard page
- [ ] Train with real employee data
- [ ] Run performance tests

### Medium-term (Month 1)
- [ ] Deploy to production
- [ ] Monitor recognition accuracy
- [ ] Gather user feedback
- [ ] Optimize thresholds

### Long-term (Quarter 1)
- [ ] Plan V1.1 features
- [ ] Research advanced algorithms
- [ ] Consider cloud deployment
- [ ] Explore mobile integration

---

## Success Metrics

Track these after deployment:

| Metric | Target | How to Measure |
|--------|--------|----------------|
| API Uptime | 99.9% | Monitor logs |
| Recognition Accuracy | 99%+ | Test with known workers |
| Avg Response Time | <500ms | Check API logs |
| Enrollment Success | 98%+ | Count successful enrollments |
| User Adoption | 80%+ | Track daily active users |

---

## Quick Links

| Document | Purpose | Time |
|----------|---------|------|
| [README.md](README.md) | Get started | 5 min |
| [INTEGRATION_GUIDE.md](INTEGRATION_GUIDE.md) | PHP integration | 15 min |
| [ARCHITECTURE.md](ARCHITECTURE.md) | Technical deep dive | 20 min |
| [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) | Project overview | 10 min |
| [FILE_STRUCTURE.md](FILE_STRUCTURE.md) | File organization | 5 min |

---

## Checklist Summary

**Before Starting**: ✓ All requirements met  
**During Setup**: ✓ Follow step-by-step  
**After Installation**: ✓ Run verification tests  
**Integration**: ✓ Use provided PHP client  
**Deployment**: ✓ Follow production checklist  

---

**You're Ready to Go! 🚀**

Start with `README.md` for a 5-minute quick start, then refer to other docs as needed.

Good luck with your capstone project!

---

*Last Updated: January 2024*  
*Version: 1.0*  
*Status: Production Ready*
