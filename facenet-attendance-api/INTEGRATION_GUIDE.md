"""
Integration Guide: FaceNet Attendance API with PHP System
"""

# FaceNet Attendance API Integration Guide

This guide shows how to integrate the FaceNet Attendance System with your existing D&G ConstructMonitor PHP application.

## Quick Start

### 1. Setup Python API Service

```bash
cd facenet-attendance-api

# Create virtual environment
python -m venv venv
source venv/bin/activate  # Windows: venv\Scripts\activate

# Install dependencies
pip install -r requirements.txt

# Copy and configure environment
cp .env.example .env
# Edit .env with your database details

# Initialize database
python -c "from app import create_app, db; app = create_app(); db.create_all()"

# Start the service
python run.py
```

Service runs at: `http://localhost:5000`

### 2. Create PHP Client Class

Create `attendance_api_client.php` in your PHP project:

```php
<?php
class FaceNetClient {
    private $api_url;
    private $token;
    private $timeout = 30;
    
    public function __construct($base_url = 'http://localhost:5000') {
        $this->api_url = $base_url . '/api/v1';
        $this->authenticate();
    }
    
    private function authenticate() {
        $response = $this->apiRequest('POST', '/auth/token', [
            'username' => 'admin',
            'password' => 'admin123'
        ], false);
        
        if (isset($response['token'])) {
            $this->token = $response['token'];
        }
    }
    
    public function enrollWorker($worker_data, $image_files) {
        $url = $this->api_url . '/enroll/worker';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $post_data = [
            'worker_id' => $worker_data['worker_id'],
            'name' => $worker_data['name'],
            'email' => $worker_data['email'],
            'phone' => $worker_data['phone'] ?? '',
            'position' => $worker_data['position'] ?? '',
            'department' => $worker_data['department'] ?? ''
        ];
        
        // Add images
        foreach ($image_files as $key => $image_path) {
            if (file_exists($image_path)) {
                $post_data['images'][] = new CURLFile($image_path);
            }
        }
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return $response;
    }
    
    public function checkinWorker($image_path, $device_id = 'WEB') {
        if (!file_exists($image_path)) {
            return ['success' => false, 'error' => 'Image file not found'];
        }
        
        $url = $this->api_url . '/recognize/checkin';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $post_data = [
            'image' => new CURLFile($image_path),
            'device_id' => $device_id,
            'location' => 'Web Checkin',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? ''
        ];
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token
        ]);
        
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return $response;
    }
    
    public function checkoutWorker($worker_id, $image_path = null) {
        $url = $this->api_url . '/recognize/checkout';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $post_data = ['worker_id' => $worker_id];
        
        if ($image_path && file_exists($image_path)) {
            $post_data['image'] = new CURLFile($image_path);
        }
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
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
        
        return $this->apiRequest('GET', '/attendance/records?' . http_build_query($params));
    }
    
    public function getWorkerSummary($worker_id, $days = 30) {
        return $this->apiRequest('GET', "/attendance/summary/$worker_id?days=$days");
    }
    
    public function getDailyReport($date = null) {
        $params = [];
        if ($date) {
            $params['date'] = $date;
        }
        
        $query = http_build_query($params);
        return $this->apiRequest('GET', "/attendance/daily-report?" . $query);
    }
    
    private function apiRequest($method, $endpoint, $data = null, $auth = true) {
        $url = $this->api_url . $endpoint;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        
        if ($auth && $this->token) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ]);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
        
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        
        $response = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $response;
    }
}
?>
```

### 3. Use in Your PHP Application

```php
<?php
require 'attendance_api_client.php';

// Initialize client
$facenet = new FaceNetClient('http://localhost:5000');

// Example 1: Enroll a worker
$enrollment_result = $facenet->enrollWorker(
    [
        'worker_id' => 'EMP001',
        'name' => 'Juan Dela Cruz',
        'email' => 'juan@dg-corp.ph',
        'position' => 'Site Engineer',
        'department' => 'Construction'
    ],
    ['photos/juan_1.jpg', 'photos/juan_2.jpg', 'photos/juan_3.jpg']
);

if ($enrollment_result['success']) {
    echo "Worker enrolled successfully!";
} else {
    echo "Enrollment failed: " . $enrollment_result['error'];
}

// Example 2: Check-in via webcam
$checkin_image = 'temp/checkin_' . time() . '.jpg';
// Capture image from webcam (JavaScript/HTML5 Canvas would do this)
// saveImageFromCamera($checkin_image);

$checkin_result = $facenet->checkinWorker($checkin_image, 'CAM-MAIN-GATE');

if ($checkin_result['success']) {
    $worker = $checkin_result['worker'];
    echo "Welcome, {$worker['name']}! Confidence: {$checkin_result['confidence']}";
    
    // Store attendance in local database
    $query = "INSERT INTO attendance (worker_id, check_in_time, confidence) 
              VALUES (?, ?, ?)";
    // Execute with your DB library
} else {
    echo "Face not recognized or low confidence";
}

// Example 3: Get attendance report
$report = $facenet->getAttendanceRecords(
    date('Y-m-d', strtotime('-30 days')),
    date('Y-m-d')
);

// Display report in your dashboard
foreach ($report['records'] as $record) {
    echo $record['worker']['name'] . ": " . $record['check_in_time'];
}
?>
```

## Integration Points

### 1. Database Synchronization

The FaceNet API maintains its own database for face encodings. You can sync with your PHP system:

```php
<?php
// sync_attendance.php - Sync FaceNet records to main database

$facenet = new FaceNetClient();

// Get today's attendance
$date = date('Y-m-d');
$report = $facenet->getDailyReport($date);

if ($report['success']) {
    foreach ($report['records'] as $record) {
        // Insert into your main attendance table
        $query = "INSERT INTO main_attendance 
                 (worker_id, check_in, check_out, confidence, status)
                 VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            'sssds',
            $record['worker']['worker_id'],
            $record['check_in_time'],
            $record['check_out_time'],
            $record['confidence_score'],
            $record['status']
        );
        $stmt->execute();
    }
}
?>
```

### 2. Admin Dashboard Integration

```php
<?php
// admin/attendance_dashboard.php

$facenet = new FaceNetClient();

// Get daily statistics
$today = date('Y-m-d');
$report = $facenet->getDailyReport($today);

?>
<div class="attendance-dashboard">
    <h2>Daily Attendance Report - <?php echo $today; ?></h2>
    
    <div class="stats">
        <div class="stat">
            <label>Present</label>
            <span><?php echo $report['statistics']['total_present']; ?></span>
        </div>
        <div class="stat">
            <label>Late</label>
            <span><?php echo $report['statistics']['total_late']; ?></span>
        </div>
        <div class="stat">
            <label>Absent</label>
            <span><?php echo $report['statistics']['total_absent']; ?></span>
        </div>
    </div>
    
    <table class="attendance-table">
        <thead>
            <tr>
                <th>Worker ID</th>
                <th>Name</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Confidence</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report['records'] as $record): ?>
            <tr>
                <td><?php echo $record['worker']['worker_id']; ?></td>
                <td><?php echo $record['worker']['name']; ?></td>
                <td><?php echo date('H:i', strtotime($record['check_in_time'])); ?></td>
                <td><?php echo $record['check_out_time'] ? date('H:i', strtotime($record['check_out_time'])) : '-'; ?></td>
                <td><?php echo number_format($record['confidence_score'], 4); ?></td>
                <td><span class="status <?php echo $record['status']; ?>"><?php echo $record['status']; ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
?>
```

### 3. Supervisor Mobile/Web Checkin

```php
<?php
// supervisor/quick_checkin.php

header('Content-Type: application/json');

require 'attendance_api_client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $facenet = new FaceNetClient();
    
    // Save uploaded image temporarily
    $temp_path = 'temp/checkin_' . time() . '.jpg';
    move_uploaded_file($_FILES['image']['tmp_name'], $temp_path);
    
    // Perform recognition
    $result = $facenet->checkinWorker($temp_path, 'MOBILE');
    
    // Clean up
    unlink($temp_path);
    
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No image provided']);
}
?>
```

## Configuration for Production

### 1. Update .env

```env
FLASK_ENV=production
DB_HOST=your.database.server
DB_USER=production_user
DB_PASSWORD=secure_password_here
CONFIDENCE_THRESHOLD=0.65
```

### 2. SSL/HTTPS

```nginx
# nginx configuration
server {
    listen 443 ssl http2;
    server_name facenet-api.yourdomain.com;
    
    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;
    
    location / {
        proxy_pass http://localhost:5000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

### 3. Docker Deployment

```bash
# Build and run with Docker
docker-compose up -d

# View logs
docker-compose logs -f facenet-api

# Scale workers
docker-compose up -d --scale facenet-api=3
```

## Error Handling

```php
<?php
try {
    $facenet = new FaceNetClient();
    $result = $facenet->checkinWorker($image_path);
    
    if (!$result['success']) {
        // Handle specific error types
        switch ($result['error']) {
            case 'No face detected in image':
                echo "Please ensure your face is clearly visible";
                break;
            case 'Face not recognized or confidence too low':
                echo "Your face was not recognized. Please enroll first.";
                break;
            default:
                echo "Recognition error: " . $result['error'];
        }
    }
} catch (Exception $e) {
    echo "API connection error: " . $e->getMessage();
    // Log error
    error_log($e->getMessage());
}
?>
```

## Performance Tips

1. **Image Size**: Keep images under 5MB
2. **Quality**: Ensure good lighting and clear face visibility
3. **Caching**: Cache enrollment data in PHP to reduce API calls
4. **Batch Processing**: Process multiple attendances asynchronously

## Monitoring

Monitor the API health and performance:

```bash
# Check API status
curl http://localhost:5000/health

# View real-time logs
tail -f facenet-attendance-api/logs/facenet_api.log

# Monitor recognition accuracy
# Query the recognition_logs table for metrics
```

## Support & Issues

For issues during integration:

1. Check `.env` configuration
2. Verify MySQL credentials
3. Review API logs
4. Test endpoints with curl/Postman
5. Check network connectivity between services

---

**D&G ConstructMonitor - FaceNet Integration**
