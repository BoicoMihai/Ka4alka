<?php
session_start();

function redirectBack($message) {
    $_SESSION['login_error'] = $message;
    $_SESSION['active_form'] = 'login';
    header('Location: index_prelog.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $storage = 'data/data.json';

    if (empty($email) || empty($password)) {
        redirectBack('Email and password are required.');
    }

    if (!file_exists($storage)) {
        redirectBack('No users are registered yet.');
    }

    $users = json_decode(file_get_contents($storage), true);
    if (!is_array($users)) {
        redirectBack('Unable to read user data.');
    }

    foreach ($users as $user) {
        if (strtolower($user['username']) === $email && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            header('Location: index.php');
            exit;
        }
    }

    redirectBack('Invalid email or password.');
}

header('Location: index_prelog.php');
exit;
