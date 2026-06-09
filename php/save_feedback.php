<?php
header('Content-Type: application/json');

function readFeedback() {
    $path = __DIR__ . '/../data/feedback.json';
    if (!file_exists($path) || filesize($path) === 0) {
        return [];
    }

    $raw = file_get_contents($path);
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

function writeFeedback(array $feedback): bool {
    $path = __DIR__ . '/../data/feedback.json';
    return file_put_contents($path, json_encode($feedback, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please complete all fields.']);
    exit;
}

$feedback = readFeedback();
$feedback[] = [
    'name' => $name,
    'email' => $email,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s')
];

if (!writeFeedback($feedback)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to save feedback.']);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Feedback saved successfully.']);
