<?php
session_start();

// Demo credentials - in production, validate against database
$DEMO_CREDENTIALS = [
    'admin@dg-corp.ph' => [
        'password' => 'password123',
        'role' => 'admin',
        'name' => 'Engr. Admin'
    ],
    'supervisor@dg-corp.ph' => [
        'password' => 'password123',
        'role' => 'supervisor',
        'name' => 'Contractor Lead'
    ],
    'client@dg-corp.ph' => [
        'password' => 'password123',
        'role' => 'client',
        'name' => 'Client Manager'
    ]
];

$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'admin';

    // Validate input
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
    } elseif (!isset($DEMO_CREDENTIALS[$email])) {
        $response['message'] = 'Email not found in system.';
    } else {
        $credentials = $DEMO_CREDENTIALS[$email];

        // Verify password
        if ($password !== $credentials['password']) {
            $response['message'] = 'Invalid password.';
        } elseif ($role !== $credentials['role']) {
            $response['message'] = 'This account does not have access to the selected role.';
        } else {
            // Set session variables
            $_SESSION['user_id'] = md5($email);
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $credentials['role'];
            $_SESSION['user_name'] = $credentials['name'];
            $_SESSION['login_time'] = time();

            $response['success'] = true;
            $response['message'] = 'Login successful!';
            $response['redirect'] = match($credentials['role']) {
                'admin' => 'admin.php',
                'supervisor' => 'supervisor.php',
                'client' => 'client.php',
                default => 'index.php'
            };
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If accessed directly via GET, redirect to index
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: index.php');
    exit;
}
?>
