<?php

session_start();
require_once 'config.php';

if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Please enter both email and password.';
        $_SESSION['active_form'] = 'login';
        header('Location: index.php');
        exit();
    }

    $stmt = $conn->prepare('SELECT name, email, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['name']  = $user['name'];
            $_SESSION['email'] = $user['email'];
            $stmt->close();
            header('Location: index.php');
            exit();
        }
    }


    $_SESSION['login_error'] = 'Incorrect email or password.';
    $_SESSION['active_form'] = 'login';
    $stmt->close();
    header('Location: index.php');
    exit();
}

header('Location: index.php');
exit();