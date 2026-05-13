# FaceNet Attendance API
Build robust face recognition powered attendance system with deep learning

## Features

- ✅ **FaceNet Face Recognition** - 128-dimensional face encoding and matching
- ✅ **Worker Enrollment** - Multi-image enrollment with quality metrics
- ✅ **Real-time Attendance** - Check-in/check-out via facial recognition
- ✅ **Comprehensive Logging** - Detailed recognition attempt logging
- ✅ **Attendance Analytics** - Summary reports and statistics
- ✅ **Production Ready** - Docker support, logging, error handling
- ✅ **REST API** - Fully documented endpoints
- ✅ **Database Integration** - MySQL/PostgreSQL support

## Project Structure

```
facenet-attendance-api/
├── app/
│   ├── __init__.py              # Flask app factory
│   ├── config/
│   │   ├── settings.py          # Configuration management
│   │   └── __init__.py
│   ├── models/
│   │   ├── models.py            # SQLAlchemy models
│   │   └── __init__.py
│   ├── services/
│   │   ├── facenet_service.py   # Face recognition core
│   │   ├── attendance_service.py # Attendance business logic
│   │   ├── enrollment_service.py # Worker enrollment
│   │   └── __init__.py
│   ├── routes/
│   │   ├── __init__.py          # Blueprint registration
│   │   ├── auth_routes.py       # Authentication endpoints
│   │   ├── enrollment_routes.py # Enrollment endpoints
│   │   ├── recognition_routes.py# Recognition endpoints
│   │   └── attendance_routes.py  # Reporting endpoints
│   └── utils/
├── data/
│   ├── face_encodings/          # Stored face encodings
│   └── uploads/                 # Temporary image storage
├── logs/                         # Application logs
├── tests/                        # Unit and integration tests
├── run.py                        # Application entry point
├── requirements.txt              # Python dependencies
├── .env.example                  # Environment template
├── Dockerfile                    # Docker image definition
├── docker-compose.yml            # Docker compose setup
└── README.md                     # This file

## Installation

### Option 1: Local Setup

1. **Clone and setup environment:**
   ```bash
   cd facenet-attendance-api
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   pip install -r requirements.txt
   ```

2. **Configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

3. **Initialize database:**
   ```bash
   python
   >>> from app import create_app, db
   >>> app = create_app()
   >>> with app.app_context():
   >>>     db.create_all()
   ```

4. **Run application:**
   ```bash
   python run.py
   ```

### Option 2: Docker Setup

1. **Build and run:**
   ```bash
   docker-compose up -d
   ```

2. **Verify health:**
   ```bash
   curl http://localhost:5000/health
   ```

## API Endpoints

### Authentication
- `GET /api/v1/auth/health` - Health check
- `POST /api/v1/auth/token` - Get JWT token

### Enrollment
- `POST /api/v1/enroll/worker` - Enroll new worker (multipart form-data)
- `GET /api/v1/enroll/worker/<worker_id>` - Get enrollment status
- `GET /api/v1/enroll/workers` - List enrolled workers

### Recognition
- `POST /api/v1/recognize/checkin` - Check-in via face (multipart form-data)
- `POST /api/v1/recognize/checkout` - Check-out via face (multipart form-data)

### Attendance
- `GET /api/v1/attendance/records` - Get attendance records with filters
- `GET /api/v1/attendance/summary/<worker_id>` - Get worker summary
- `GET /api/v1/attendance/daily-report` - Get daily report

## Usage Examples

### 1. Enroll Worker

```bash
curl -X POST http://localhost:5000/api/v1/enroll/worker \
  -F "worker_id=EMP001" \
  -F "name=Juan Dela Cruz" \
  -F "email=juan@dg-corp.ph" \
  -F "position=Site Engineer" \
  -F "department=Construction" \
  -F "images=@photo1.jpg" \
  -F "images=@photo2.jpg" \
  -F "images=@photo3.jpg"
```

### 2. Check-in via Face

```bash
curl -X POST http://localhost:5000/api/v1/recognize/checkin \
  -F "image=@checkin_photo.jpg" \
  -F "device_id=CAM-01" \
  -F "location=Main Gate"
```

### 3. Get Attendance Records

```bash
curl "http://localhost:5000/api/v1/attendance/records?start_date=2024-01-01&end_date=2024-01-31&page=1&per_page=20"
```

### 4. Get Worker Summary

```bash
curl "http://localhost:5000/api/v1/attendance/summary/EMP001?days=30"
```

## Integration with PHP System

### In your PHP application:

```php
<?php
// attendance_api_client.php

class FaceNetAttendanceClient {
    private $api_url = 'http://localhost:5000/api/v1';
    private $token = null;
    
    public function __construct() {
        $this->authenticate();
    }
    
    private function authenticate() {
        $ch = curl_init($this->api_url . '/auth/token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'username' => 'admin',
            'password' => 'admin123'
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = json_decode(curl_exec($ch), true);
        $this->token = $response['token'] ?? null;
        curl_close($ch);
    }
    
    public function checkinWorker($image_path, $device_id = 'WEB') {
        $ch = curl_init($this->api_url . '/recognize/checkin');
        
        $post_data = [
            'image' => new CURLFile($image_path),
            'device_id' => $device_id,
            'location' => 'Web Checkin'
        ];
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token
        ]);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return $response;
    }
    
    public function getAttendanceRecords($start_date, $end_date, $worker_id = null) {
        $params = [
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        
        if ($worker_id) {
            $params['worker_id'] = $worker_id;
        }
        
        $url = $this->api_url . '/attendance/records?' . http_build_query($params);
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token
        ]);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return $response;
    }
}

// Usage
$facenet = new FaceNetAttendanceClient();
$result = $facenet->checkinWorker('employee_photo.jpg');

if ($result['success']) {
    echo "Welcome, " . $result['worker']['name'];
    // Store attendance in local database
} else {
    echo "Face not recognized";
}
?>
```

## Database Schema

### Workers Table
- `id` - Primary key
- `worker_id` - Unique employee identifier
- `name` - Full name
- `email` - Email address
- `position` - Job position
- `department` - Department
- `is_enrolled` - Enrollment status
- `enrollment_date` - Date of enrollment
- `created_at` - Record creation time

### FaceEncodings Table
- `id` - Primary key
- `worker_id` - Foreign key to workers
- `encoding_data` - 128-dimensional face vector (hex encoded)
- `image_hash` - SHA256 of original image
- `quality_score` - Quality metric (0-1)
- `is_primary` - Primary encoding flag

### AttendanceRecords Table
- `id` - Primary key
- `worker_id` - Foreign key to workers
- `check_in_time` - Check-in timestamp
- `check_out_time` - Check-out timestamp
- `date` - Attendance date
- `confidence_score` - Face matching confidence
- `face_distance` - Euclidean distance metric
- `status` - Status (present, late, absent)

## Configuration

Create `.env` file based on `.env.example`:

```env
# Core
FLASK_ENV=production
SECRET_KEY=your-secret-key-here

# Database
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=dg_construct_monitor
DB_USER=root
DB_PASSWORD=password

# FaceNet
CONFIDENCE_THRESHOLD=0.6
DISTANCE_THRESHOLD=0.5
FACE_RECOGNITION_TOLERANCE=0.6
FACE_RECOGNITION_MODEL=hog  # or 'cnn' for higher accuracy

# API
MAX_FILE_SIZE=16777216
ALLOWED_EXTENSIONS=jpg,jpeg,png
LOG_LEVEL=INFO
```

## Performance Optimization

- **Model**: Uses HOG (Histogram of Oriented Gradients) for speed, can switch to CNN for accuracy
- **Tolerance**: Lower tolerance (0.3-0.4) for stricter matching, higher (0.6-0.7) for permissive matching
- **Batch Processing**: Process multiple faces in parallel (configurable MAX_WORKERS)
- **Caching**: Encodings cached in memory for faster matching

## Security Considerations

- JWT token-based authentication
- CORS configured for trusted origins
- Input validation on all endpoints
- SQL injection prevention via SQLAlchemy ORM
- Image file type validation
- Rate limiting recommended for production
- HTTPS recommended for deployment

## Monitoring & Logging

All API calls, face recognition attempts, and errors are logged to:
- `logs/facenet_api.log` - Application logs
- Database `recognition_logs` table - Detailed recognition attempts

Monitor key metrics:
- Recognition success rate
- Average confidence scores
- Processing times
- False positive/negative rates

## Testing

Run tests:
```bash
pytest tests/
```

## Troubleshooting

### No faces detected
- Ensure image is clear and well-lit
- Face should be frontal and at least 50x50 pixels
- Check image format (JPG, PNG supported)

### Low confidence scores
- Enroll with better quality images
- Ensure consistent lighting during enrollment
- Use frontal face images

### Database connection errors
- Verify DB credentials in .env
- Check MySQL server is running
- Ensure database exists

## Future Enhancements

- [ ] Multi-face detection in single image
- [ ] Liveness detection (anti-spoofing)
- [ ] Batch enrollment from directory
- [ ] Face mask handling
- [ ] Age/gender estimation
- [ ] Attendance dashboard UI
- [ ] Mobile app integration
- [ ] Cloud deployment (AWS, GCP)

## License

Proprietary - D&G Development Corporation

## Support

For issues and questions, contact: info@dg-corp.ph

---

**Built for D&G ConstructMonitor - Construction Project Monitoring System**
