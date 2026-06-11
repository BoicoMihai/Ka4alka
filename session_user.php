<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); exit();
}
$raw_username    = $_SESSION['username'];
$display_name    = strstr($raw_username, '@', true); 
if (!$display_name) $display_name = $raw_username;    

$display_name    = ucfirst($display_name);

$safe_display    = htmlspecialchars($display_name,   ENT_QUOTES, 'UTF-8');
$safe_raw        = htmlspecialchars($raw_username,   ENT_QUOTES, 'UTF-8');
?>