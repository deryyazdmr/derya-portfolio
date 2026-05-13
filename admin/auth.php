<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function start_admin_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function require_admin(): void
{
    start_admin_session();

    if (!isset($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

function current_admin_name(): string
{
    start_admin_session();
    return $_SESSION['admin_username'] ?? 'Admin';
}

function csrf_token(): string
{
    start_admin_session();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    start_admin_session();
    $token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('Invalid security token.');
    }
}
