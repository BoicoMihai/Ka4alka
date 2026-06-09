<?php
// php/session_user.php
// Include this at the top of every authenticated page (index.php, library.php, new_workout.php, etc.)
// Usage:  require_once __DIR__ . '/php/session_user.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); exit();
}

// $_SESSION['username'] stores the email (e.g. john@example.com).
// We derive a display name from the part before the @ sign.
$raw_username    = $_SESSION['username'];
$display_name    = strstr($raw_username, '@', true);   // "john" from "john@example.com"
if (!$display_name) $display_name = $raw_username;     // fallback if no @ (plain username)

// Capitalise first letter so it looks like a real name
$display_name    = ucfirst($display_name);

$safe_display    = htmlspecialchars($display_name,   ENT_QUOTES, 'UTF-8');
$safe_raw        = htmlspecialchars($raw_username,   ENT_QUOTES, 'UTF-8');
?>