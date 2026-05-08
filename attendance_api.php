<?php
require_once __DIR__ . '/db.php';

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
        $logResult = $connection->query('SELECT worker_id, worker_name, worker_role, project, date_key, time_in, status, score, scan_source FROM attendance_logs ORDER BY date_key DESC, time_in DESC, id DESC');
        while ($row = $logResult->fetch_assoc()) {
            $logs[] = [
                'workerId' => $row['worker_id'],
                'workerName' => $row['worker_name'],
                'workerRole' => $row['worker_role'],
                'project' => $row['project'],
                'dateKey' => $row['date_key'],
                'timeIn' => substr((string) $row['time_in'], 0, 5),
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
        $status = trim((string) ($log['status'] ?? ''));
        $score = isset($log['score']) ? (float) $log['score'] : null;
        $scanSource = trim((string) ($log['scanSource'] ?? 'group_photo')) ?: 'group_photo';

        if ($workerId === '' || $workerName === '' || $workerRole === '' || $project === '' || $dateKey === '' || $timeIn === '' || $status === '') {
            dg_json_response(['success' => false, 'message' => 'Invalid attendance payload.'], 422);
        }

        $statement = $connection->prepare('INSERT INTO attendance_logs (worker_id, worker_name, worker_role, project, date_key, time_in, status, score, scan_source) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE worker_name = VALUES(worker_name), worker_role = VALUES(worker_role), time_in = VALUES(time_in), status = VALUES(status), score = VALUES(score), scan_source = VALUES(scan_source)');
        $statement->bind_param('sssssssds', $workerId, $workerName, $workerRole, $project, $dateKey, $timeIn, $status, $score, $scanSource);
        $statement->execute();
        $statement->close();

        dg_json_response(['success' => true]);
    }

    dg_json_response(['success' => false, 'message' => 'Unsupported action.'], 400);
} catch (Throwable $exception) {
    dg_json_response(['success' => false, 'message' => $exception->getMessage()], 500);
}
