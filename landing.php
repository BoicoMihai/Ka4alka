<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ka4alka — Track Your Workouts</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/landing.css">
</head>
<body>
  <nav class="nav">
    <a href="landing.php" class="nav-logo">
      <img src="images/logo.png" alt="Ka4alka logo">
      Ka4alka
    </a>
    <div class="nav-auth">
      <a href="login.php" class="btn-ghost">Log in</a>
      <a href="register.php" class="btn-primary">Sign up</a>
    </div>
  </nav>

  <section class="hero">
    <h1 class="hero-title">
      Train smarter.<br>
      <span class="highlight">Track everything.</span>
    </h1>
    <p class="hero-subtitle">
      Ka4alka gives you a personal workout log, a full exercise library,
      and routines built around the way you actually train.
    </p>
    <div class="hero-actions">
      <a href="register.php" class="btn-primary btn-large">Start for free</a>
      <a href="login.php" class="btn-ghost btn-large">Log in</a>
    </div>
  </section>

</body>
</html>