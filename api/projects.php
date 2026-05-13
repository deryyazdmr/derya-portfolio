<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

try {
    $stmt = db()->query(
        'SELECT id, title, description, technologies, project_url
         FROM projects
         WHERE is_published = 1
         ORDER BY display_order ASC, created_at DESC'
    );

    echo json_encode([
        'success' => true,
        'projects' => $stmt->fetchAll(),
    ]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Projects could not be loaded.',
    ]);
}
