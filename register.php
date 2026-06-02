<?php

session_start();
require_once "config.php";

if (isset($_POST['register'])) {
    $name     = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists using a prepared statement
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already taken — send error back to index.php
        $_SESSION['register_error'] = 'An account with that email already exists.';
        $_SESSION['active_form']    = 'register';
        $stmt->close();
        header("Location: index.php");
        exit();
    }

    $stmt->close();

    // Insert new user using a prepared statement (prevents SQL injection)
    $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $name, $email, $password);

    if ($insert->execute()) {
        $insert->close();
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['register_error'] = 'Registration failed. Please try again.';
        $_SESSION['active_form']    = 'register';
        $insert->close();
        header("Location: index.php");
        exit();
    }
}

// If accessed directly without a POST request, redirect home
header("Location: index.php");
exit();