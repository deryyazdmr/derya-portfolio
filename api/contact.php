<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = clean_input($_POST['name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$subject = clean_input($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || !$email || $subject === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
}

if (mb_strlen($name) < 2 || mb_strlen($subject) < 3 || mb_strlen($message) < 10) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Please check your form values.']);
    exit;
}

try {
    $stmt = db()->prepare(
        'INSERT INTO contact_messages (name, email, subject, message, ip_address)
         VALUES (:name, :email, :subject, :message, :ip_address)'
    );
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    echo json_encode(['success' => true, 'message' => 'Message saved.']);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Message could not be saved.']);
}
