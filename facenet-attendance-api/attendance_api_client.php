<?php
/**
 * FaceNet Attendance API Client for PHP
 * Integration with D&G ConstructMonitor
 * 
 * Usage:
 *   $client = new FaceNetAttendanceClient('http://localhost:5000');
 *   $result = $client->checkinWorker('/path/to/image.jpg');
 */

class FaceNetAttendanceClient {
    private $api_url;
    private $token = null;
    private $timeout = 30;
    private $last_error = null;
    
    /**
     * Initialize FaceNet client
     * 
     * @param string $base_url API base URL (default: localhost:5000)
     * @param string $username API username (default: admin)
     * @param string $password API password (default: admin123)
     */
    public function __construct($base_url = 'http://localhost:5000', $username = 'admin', $password = 'admin123') {
        $this->api_url = rtrim($base_url, '/') . '/api/v1';
        $this->authenticate($username, $password);
    }
    
    /**
     * Authenticate and get JWT token
     */
    private function authenticate($username, $password) {
        try {
            $response = $this->makeRequest('POST', '/auth/token', [
                'username' => $username,
                'password' => $password
            ], false);
            
            if (isset($response['token'])) {
                $this->token = $response['token'];
                return true;
            }
            
            $this->last_error = 'Authentication failed';
            return false;
        } catch (Exception $e) {
            $this->last_error = 'Authentication error: ' . $e->getMessage();
            return false;
        }
    }
    
    /**
     * Enroll a worker with face images
     * 
     * @param array $worker_data Worker information
     * @param array $image_paths Array of image file paths
     * @return array API response
     */
    public function enrollWorker($worker_data, $image_paths) {
        try {
            $url = $this->api_url . '/enroll/worker';
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            
            // Prepare POST data
            $post_data = [
                'worker_id' => $worker_data['worker_id'] ?? '',
                'name' => $worker_data['name'] ?? '',
                'email' => $worker_data['email'] ?? '',
                'phone' => $worker_data['phone'] ?? '',
                'position' => $worker_data['position'] ?? '',
                'department' => $worker_data['department'] ?? ''
            ];
            
            // Add images
            foreach ($image_paths as $image_path) {
                if (file_exists($image_path)) {
                    $post_data['images'] = array_merge(
                        isset($post_data['images']) ? $post_data['images'] : [],
                        [new CURLFile($image_path)]
                    );
                }
            }
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->token
            ]);
            
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);
            
            return $response;
        } catch (Exception $e) {
            $this->last_error = 'Enrollment error: ' . $e->getMessage();
            return ['success' => false, 'error' => $this->last_error];
        }
    }
    
    /**
     * Check in a worker using face recognition
     * 
     * @param string $image_path Path to face image
     * @param string $device_id Device/camera ID
     * @param string $location Check-in location
     * @return array API response
     */
    public function checkinWorker($image_path, $device_id = 'WEB', $location = 'Web Checkin') {
        try {
            if (!file_exists($image_path)) {
                return ['success' => false, 'error' => 'Image file not found: ' . $image_path];
            }
            
            $url = $this->api_url . '/recognize/checkin';
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            
            $post_data = [
                'image' => new CURLFile($image_path),
                'device_id' => $device_id,
                'location' => $location,
                'ip_address' => $this->getClientIP()
            ];
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->token
            ]);
            
            $response = json_decode(curl_exec($ch), true);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            return $response ?? ['success' => false, 'error' => 'API error: HTTP ' . $http_code];
        } catch (Exception $e) {
            $this->last_error = 'Check-in error: ' . $e->getMessage();
            return ['success' => false, 'error' => $this->last_error];
        }
    }
    
    /**
     * Check out a worker
     * 
     * @param string $worker_id Worker ID
     * @param string|null $image_path Optional check-out image
     * @return array API response
     */
    public function checkoutWorker($worker_id, $image_path = null) {
        try {
            $url = $this->api_url . '/recognize/checkout';
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            
            $post_data = ['worker_id' => $worker_id];
            
            if ($image_path && file_exists($image_path)) {
                $post_data['image'] = new CURLFile($image_path);
            }
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->token
            ]);
            
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);
            
            return $response;
        } catch (Exception $e) {
            $this->last_error = 'Check-out error: ' . $e->getMessage();
            return ['success' => false, 'error' => $this->last_error];
        }
    }
    
    /**
     * Get attendance records
     * 
     * @param string $start_date Start date (YYYY-MM-DD)
     * @param string $end_date End date (YYYY-MM-DD)
     * @param string|null $worker_id Filter by worker ID
     * @param int $page Page number
     * @param int $per_page Records per page
     * @return array API response
     */
    public function getAttendanceRecords($start_date, $end_date, $worker_id = null, $page = 1, $per_page = 20) {
        $params = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'page' => $page,
            'per_page' => $per_page
        ];
        
        if ($worker_id) {
            $params['worker_id'] = $worker_id;
        }
        
        return $this->makeRequest('GET', '/attendance/records?' . http_build_query($params));
    }
    
    /**
     * Get worker attendance summary
     * 
     * @param string $worker_id Worker ID
     * @param int $days Number of days to look back
     * @return array API response
     */
    public function getWorkerSummary($worker_id, $days = 30) {
        return $this->makeRequest('GET', "/attendance/summary/$worker_id?days=$days");
    }
    
    /**
     * Get daily attendance report
     * 
     * @param string|null $date Date in YYYY-MM-DD format (default: today)
     * @param string|null $status Filter by status (present, late, absent)
     * @return array API response
     */
    public function getDailyReport($date = null, $status = null) {
        $params = [];
        
        if ($date) {
            $params['date'] = $date;
        }
        
        if ($status) {
            $params['status'] = $status;
        }
        
        $query = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->makeRequest('GET', '/attendance/daily-report' . $query);
    }
    
    /**
     * Get enrolled workers list
     * 
     * @param int $page Page number
     * @param int $per_page Records per page
     * @return array API response
     */
    public function getEnrolledWorkers($page = 1, $per_page = 20) {
        return $this->makeRequest('GET', '/enroll/workers?page=' . $page . '&per_page=' . $per_page);
    }
    
    /**
     * Get worker enrollment status
     * 
     * @param string $worker_id Worker ID
     * @return array API response
     */
    public function getWorkerStatus($worker_id) {
        return $this->makeRequest('GET', '/enroll/worker/' . urlencode($worker_id));
    }
    
    /**
     * Check API health
     * 
     * @return bool
     */
    public function healthCheck() {
        try {
            $response = $this->makeRequest('GET', '/auth/health', null, false);
            return isset($response['status']) && $response['status'] === 'healthy';
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Get last error message
     * 
     * @return string|null
     */
    public function getLastError() {
        return $this->last_error;
    }
    
    /**
     * Make HTTP request to API
     * 
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array|null $data Request data
     * @param bool $auth Include authorization header
     * @return array Response data
     */
    private function makeRequest($method, $endpoint, $data = null, $auth = true) {
        $url = $this->api_url . $endpoint;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        
        $headers = ['Content-Type: application/json'];
        
        if ($auth && $this->token) {
            $headers[] = 'Authorization: Bearer ' . $this->token;
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        if ($method === 'POST' && $data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('CURL error: ' . $error);
        }
        
        $decoded = json_decode($response, true);
        
        if ($http_code >= 400 && $decoded === null) {
            throw new Exception('API error: HTTP ' . $http_code);
        }
        
        return $decoded ?? ['success' => false, 'error' => 'Invalid response'];
    }
    
    /**
     * Get client IP address
     * 
     * @return string
     */
    private function getClientIP() {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }
    }
}
?>
