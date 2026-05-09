<?php
function dg_initialize_schema(mysqli $connection): void
{
    $connection->query("CREATE DATABASE IF NOT EXISTS `D&G` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    if (!$connection->select_db('D&G')) {
        throw new RuntimeException('Database selection failed: ' . $connection->error);
    }

    $connection->query(<<<SQL
CREATE TABLE IF NOT EXISTS workers (
    id VARCHAR(32) NOT NULL,
    name VARCHAR(150) NOT NULL,
    role_name VARCHAR(100) NOT NULL,
    project VARCHAR(150) NOT NULL,
    photo_name VARCHAR(255) DEFAULT NULL,
    descriptor_json JSON NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
    );

    $connection->query(<<<SQL
CREATE TABLE IF NOT EXISTS attendance_logs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    worker_id VARCHAR(32) NOT NULL,
    worker_name VARCHAR(150) NOT NULL,
    worker_role VARCHAR(100) NOT NULL,
    project VARCHAR(150) NOT NULL,
    date_key DATE NOT NULL,
    time_in TIME NOT NULL,
    status VARCHAR(30) NOT NULL,
    score DECIMAL(6,3) DEFAULT NULL,
    scan_source VARCHAR(50) NOT NULL DEFAULT 'group_photo',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_worker_date (worker_id, date_key),
    KEY idx_date_key (date_key),
    KEY idx_project (project)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
SQL
    );
}

function dg_db_connection(): mysqli
{
    $connection = new mysqli('localhost', 'root', '');

    if ($connection->connect_error) {
        throw new RuntimeException('Database connection failed: ' . $connection->connect_error);
    }

    dg_initialize_schema($connection);
    $connection->set_charset('utf8mb4');

    return $connection;
}

function dg_json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}