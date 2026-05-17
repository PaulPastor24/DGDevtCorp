<?php
require_once __DIR__ . '/db.php';

/**
 * Determine match status based on confidence score
 * @param float $confidence Confidence score 0-100
 * @return array ['status' => 'verified'|'possible'|'rejected', 'label' => string, 'matchStatus' => string]
 */
function dg_get_match_status($confidence): array
{
    if ($confidence >= 90) {
        return [
            'status' => 'verified',
            'label' => 'Verified Match',
            'matchStatus' => 'verified'
        ];
    } elseif ($confidence >= 80) {
        return [
            'status' => 'possible',
            'label' => 'Possible Match',
            'matchStatus' => 'possible'
        ];
    } else {
        return [
            'status' => 'rejected',
            'label' => 'Unrecognized',
            'matchStatus' => 'rejected'
        ];
    }
}

/**
 * Check if worker already has Time In logged today
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key (YYYY-MM-DD)
 * @return bool True if Time In exists, false otherwise
 */
function dg_worker_already_logged(mysqli $connection, $workerId, $dateKey): bool
{
    $statement = $connection->prepare('SELECT id FROM attendance_logs WHERE worker_id = ? AND date_key = ? AND action = "time_in" LIMIT 1');
    $statement->bind_param('ss', $workerId, $dateKey);
    $statement->execute();
    $result = $statement->get_result();
    $exists = $result->num_rows > 0;
    $statement->close();
    return $exists;
}

/**
 * Check if a worker has completed all four main cycles (Time In, Break Out, Break In, Time Out) for the day
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key
 * @return bool True if all cycles completed, false otherwise
 */
function dg_is_attendance_completed(mysqli $connection, $workerId, $dateKey): bool
{
    $statement = $connection->prepare('SELECT action FROM attendance_logs WHERE worker_id = ? AND date_key = ? ORDER BY id ASC');
    $statement->bind_param('ss', $workerId, $dateKey);
    $statement->execute();
    $result = $statement->get_result();
    
    $hasTimeIn = false;
    $hasBreakOut = false;
    $hasBreakIn = false;
    $hasTimeOut = false;
    
    while ($row = $result->fetch_assoc()) {
        $action = $row['action'] ?? 'time_in';
        if ($action === 'time_in') $hasTimeIn = true;
        if ($action === 'break_out') $hasBreakOut = true;
        if ($action === 'break_in') $hasBreakIn = true;
        if ($action === 'time_out') $hasTimeOut = true;
    }
    $statement->close();
    
    // All four cycles must be present
    return $hasTimeIn && $hasBreakOut && $hasBreakIn && $hasTimeOut;
}

/**
 * Validate attendance action based on workflow rules
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key
 * @param string $action The action to validate
 * @return array ['valid' => bool, 'message' => string]
 */
function dg_validate_attendance_action(mysqli $connection, $workerId, $dateKey, $action): array
{
    // Check if worker has already completed all cycles for the day
    if (dg_is_attendance_completed($connection, $workerId, $dateKey)) {
        return ['valid' => false, 'message' => 'Attendance already completed for today. Duplicate attendance detected.'];
    }

    $statement = $connection->prepare('SELECT action FROM attendance_logs WHERE worker_id = ? AND date_key = ? ORDER BY id DESC LIMIT 1');
    $statement->bind_param('ss', $workerId, $dateKey);
    $statement->execute();
    $result = $statement->get_result();
    $lastAction = $result->fetch_assoc()['action'] ?? null;
    $statement->close();

    // Workflow rules - enforced strict sequence
    if ($action === 'time_in') {
        // Cannot have duplicate Time In without Time Out
        if ($lastAction === 'time_in' || ($lastAction !== 'time_out' && $lastAction !== null)) {
            return ['valid' => false, 'message' => 'Worker already timed in. Cannot have duplicate Time In.'];
        }
    } elseif ($action === 'break_out') {
        if ($lastAction !== 'time_in') {
            return ['valid' => false, 'message' => 'Must Time In before Break Out'];
        }
    } elseif ($action === 'break_in') {
        if ($lastAction !== 'break_out') {
            return ['valid' => false, 'message' => 'Must Break Out before Break In'];
        }
    } elseif ($action === 'time_out') {
        if (!$lastAction || $lastAction === 'time_out') {
            return ['valid' => false, 'message' => 'Must Time In before Time Out'];
        }
        // Time Out is allowed after: time_in, break_out, or break_in
        if ($lastAction !== 'time_in' && $lastAction !== 'break_out' && $lastAction !== 'break_in') {
            return ['valid' => false, 'message' => 'Invalid state for Time Out'];
        }
    }

    return ['valid' => true, 'message' => 'Valid action'];
}

/**
 * Get highest confidence score for worker on a given date
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key (YYYY-MM-DD)
 * @return float|null Highest confidence score or null
 */
function dg_get_highest_confidence(mysqli $connection, $workerId, $dateKey): ?float
{
    $statement = $connection->prepare('SELECT MAX(score) as max_score FROM attendance_logs WHERE worker_id = ? AND date_key = ?');
    $statement->bind_param('ss', $workerId, $dateKey);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $statement->close();
    return $row['max_score'] ? (float)$row['max_score'] : null;
}

/**
 * Convert time string (HH:MM) to minutes since midnight
 * @param string $timeStr Time in HH:MM format
 * @return int Minutes since midnight
 */
function dg_time_to_minutes($timeStr): int
{
    if (!$timeStr) return 0;
    $parts = explode(':', $timeStr);
    return intval($parts[0] ?? 0) * 60 + intval($parts[1] ?? 0);
}

/**
 * Calculate Time Out status based on actual timestamp
 * - Before 5:00 PM (17:00): "Early Out"
 * - 5:00 PM to before 6:00 PM (17:00-17:59): "Done"
 * - 6:00 PM (18:00) onwards: "Overtime"
 * @param string $timeOutValue Time Out value (HH:MM format)
 * @return string Status: 'Early Out', 'Done', or 'Overtime'
 */
function dg_get_time_out_status($timeOutValue): string
{
    if (!$timeOutValue) {
        return 'Pending';
    }
    
    $timeOutMinutes = dg_time_to_minutes($timeOutValue);
    
    // 5:00 PM = 17 * 60 = 1020 minutes
    $fivepmMinutes = 17 * 60;      // 1020
    $sixpmMinutes = 18 * 60;        // 1080
    
    if ($timeOutMinutes < $fivepmMinutes) {
        return 'Early Out';
    } elseif ($timeOutMinutes < $sixpmMinutes) {
        return 'Done';
    } else {
        return 'Overtime';
    }
}

/**
 * Determine attendance status based on workflow state and time
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key
 * @param string $timeIn Time In value (HH:MM format)
 * @return string Status: 'Present', 'Late', 'Pending Break In', 'Pending Time Out', 'Overtime', etc.
 */
function dg_get_attendance_status(mysqli $connection, $workerId, $dateKey, $timeIn): string
{
    // Get all actions for this worker today
    $statement = $connection->prepare('SELECT action FROM attendance_logs WHERE worker_id = ? AND date_key = ? ORDER BY id ASC');
    $statement->bind_param('ss', $workerId, $dateKey);
    $statement->execute();
    $result = $statement->get_result();
    $actions = [];
    while ($row = $result->fetch_assoc()) {
        $actions[] = $row['action'];
    }
    $statement->close();

    // Default start time (7:00 AM)
    $standardStartTime = 7 * 60; // 420 minutes
    $timeInMinutes = dg_time_to_minutes($timeIn);

    // Determine status based on current state
    $lastAction = end($actions) ?: null;

    if (!$lastAction) {
        // No actions yet
        return 'Pending';
    }

    if ($lastAction === 'time_in') {
        // Just timed in, check if late
        if ($timeInMinutes > $standardStartTime + 15) {
            return 'Late';
        }
        return 'Present';
    }

    if ($lastAction === 'break_out') {
        return 'On Break';
    }

    if ($lastAction === 'break_in') {
        return 'Pending Time Out';
    }

    if ($lastAction === 'time_out') {
        // Get the actual Time Out value and calculate status dynamically
        $timeOutTime = dg_get_action_time($connection, $workerId, $dateKey, 'time_out');
        return dg_get_time_out_status($timeOutTime);
    }

    return 'Present';
}

/**
 * Get time for a specific action
 * @param mysqli $connection Database connection
 * @param string $workerId Worker ID
 * @param string $dateKey Date key
 * @param string $action Action type
 * @return string|null Time in HH:MM format or null
 */
function dg_get_action_time(mysqli $connection, $workerId, $dateKey, $action): ?string
{
    $statement = $connection->prepare('SELECT time_in FROM attendance_logs WHERE worker_id = ? AND date_key = ? AND action = ? ORDER BY id DESC LIMIT 1');
    $statement->bind_param('sss', $workerId, $dateKey, $action);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $statement->close();
    return $row ? substr((string)$row['time_in'], 0, 5) : null;
}

function dg_default_workers(): array
{
    return [
        ['id' => 'W-0024', 'name' => 'Roberto Dizon', 'role' => 'Mason', 'project' => 'San Pablo Commercial Hub', 'descriptor' => null, 'photoName' => ''],
        ['id' => 'W-0037', 'name' => 'Bong Pascual', 'role' => 'Electrician', 'project' => 'San Pablo Commercial Hub', 'descriptor' => null, 'photoName' => ''],
    ];
}

function dg_seed_defaults(mysqli $connection): void
{
    $workerCount = (int) $connection->query('SELECT COUNT(*) AS total FROM workers')->fetch_assoc()['total'];
    if ($workerCount === 0) {
        $statement = $connection->prepare('INSERT INTO workers (id, name, role_name, project, photo_name, descriptor_json) VALUES (?, ?, ?, ?, ?, ?)');
        foreach (dg_default_workers() as $worker) {
            $descriptorJson = json_encode($worker['descriptor']);
            $photoName = $worker['photoName'] ?: null;
            $statement->bind_param('ssssss', $worker['id'], $worker['name'], $worker['role'], $worker['project'], $photoName, $descriptorJson);
            $statement->execute();
        }
        $statement->close();
    }

    $logCount = (int) $connection->query('SELECT COUNT(*) AS total FROM attendance_logs')->fetch_assoc()['total'];
    if ($logCount === 0) {
    }
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true);
if (is_array($input)) {
    $action = $input['action'] ?? $action;
}

try {
    $connection = dg_db_connection();
    dg_seed_defaults($connection);

    if ($action === 'bootstrap') {
        $workers = [];
        $workerResult = $connection->query('SELECT id, name, role_name, project, photo_name, descriptor_json FROM workers ORDER BY name ASC');
        while ($row = $workerResult->fetch_assoc()) {
            $workers[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'role' => $row['role_name'],
                'project' => $row['project'],
                'photoName' => $row['photo_name'] ?? '',
                'descriptor' => $row['descriptor_json'] ? json_decode($row['descriptor_json'], true) : null,
            ];
        }

        $logs = [];
        $logResult = $connection->query('SELECT worker_id, worker_name, worker_role, project, date_key, time_in, action, status, score, scan_source FROM attendance_logs ORDER BY date_key DESC, time_in DESC, id DESC');
        while ($row = $logResult->fetch_assoc()) {
            $logs[] = [
                'workerId' => $row['worker_id'],
                'workerName' => $row['worker_name'],
                'workerRole' => $row['worker_role'],
                'project' => $row['project'],
                'dateKey' => $row['date_key'],
                'timeIn' => substr((string) $row['time_in'], 0, 5),
                'action' => $row['action'] ?? 'time_in',
                'status' => $row['status'],
                'score' => $row['score'] !== null ? (float) $row['score'] : null,
                'scanSource' => $row['scan_source'],
            ];
        }

        dg_json_response(['success' => true, 'workers' => $workers, 'logs' => $logs]);
    }

    if ($action === 'save-worker') {
        $payload = $input ?? $_POST;
        $worker = $payload['worker'] ?? $payload;

        $id = trim((string) ($worker['id'] ?? ''));
        $name = trim((string) ($worker['name'] ?? ''));
        $role = trim((string) ($worker['role'] ?? ''));
        $project = trim((string) ($worker['project'] ?? ''));
        $photoName = trim((string) ($worker['photoName'] ?? '')) ?: null;
        $descriptor = $worker['descriptor'] ?? null;

        if ($id === '' || $name === '' || $role === '' || $project === '' || !is_array($descriptor)) {
            dg_json_response(['success' => false, 'message' => 'Invalid worker payload.'], 422);
        }

        $descriptorJson = json_encode(array_values($descriptor));
        $statement = $connection->prepare('INSERT INTO workers (id, name, role_name, project, photo_name, descriptor_json) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), role_name = VALUES(role_name), project = VALUES(project), photo_name = VALUES(photo_name), descriptor_json = VALUES(descriptor_json)');
        $statement->bind_param('ssssss', $id, $name, $role, $project, $photoName, $descriptorJson);
        $statement->execute();
        $statement->close();

        dg_json_response(['success' => true]);
    }

    if ($action === 'save-attendance') {
        $payload = $input ?? $_POST;
        $log = $payload['log'] ?? $payload;

        $workerId = trim((string) ($log['workerId'] ?? ''));
        $workerName = trim((string) ($log['workerName'] ?? ''));
        $workerRole = trim((string) ($log['workerRole'] ?? ''));
        $project = trim((string) ($log['project'] ?? ''));
        $dateKey = trim((string) ($log['dateKey'] ?? ''));
        $timeIn = trim((string) ($log['timeIn'] ?? ''));
        $action_type = trim((string) ($log['action'] ?? 'time_in'));
        $status = trim((string) ($log['status'] ?? ''));
        $score = isset($log['score']) ? (float) $log['score'] : null;
        $scanSource = trim((string) ($log['scanSource'] ?? 'group_photo')) ?: 'group_photo';

        if ($workerId === '' || $workerName === '' || $workerRole === '' || $project === '' || $dateKey === '' || $timeIn === '' || $status === '') {
            dg_json_response(['success' => false, 'message' => 'Invalid attendance payload.'], 422);
        }

        // Validate attendance action based on workflow rules
        $validation = dg_validate_attendance_action($connection, $workerId, $dateKey, $action_type);
        if (!$validation['valid']) {
            dg_json_response(['success' => false, 'message' => $validation['message']], 422);
        }

        // Determine match status from confidence score
        $matchStatusData = dg_get_match_status($score ?? 0);
        $matchStatus = $matchStatusData['matchStatus'];

        // Only log verified and possible matches
        if ($matchStatus === 'verified' || $matchStatus === 'possible') {
            $statement = $connection->prepare('INSERT INTO attendance_logs (worker_id, worker_name, worker_role, project, date_key, time_in, action, status, score, scan_source) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $statement->bind_param('ssssssssds', $workerId, $workerName, $workerRole, $project, $dateKey, $timeIn, $action_type, $status, $score, $scanSource);
            $statement->execute();
            $statement->close();
            dg_json_response(['success' => true, 'action' => $action_type, 'message' => ucfirst(str_replace('_', ' ', $action_type)) . ' recorded']);
        } else {
            // Rejected matches (< 80%) are not logged
            dg_json_response(['success' => true, 'wasRejected' => true, 'message' => 'Match confidence below threshold, not logged']);
        }
    }

    dg_json_response(['success' => false, 'message' => 'Unsupported action.'], 400);
} catch (Throwable $exception) {
    dg_json_response(['success' => false, 'message' => $exception->getMessage()], 500);
}
