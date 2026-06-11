<?php require_once __DIR__ . '/session_user.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Workout – Ka4alka</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/new_workout.css">
</head>
<body>

  <!-- Inject user so sidebar localStorage key matches other pages -->
  <script>
    window.KA4ALKA_USER    = <?= json_encode($safe_raw) ?>;
    window.KA4ALKA_DISPLAY = <?= json_encode($safe_display) ?>;
  </script>

  <header class="header">
    <div class="header-left">
        <a href="index.php">
          <button type="button">
            <img src="images/logo.png" alt="Logo" class="logo">
          </button>
        </a>
      <p>Ka4alka</p>
      <button class="sidebar-toggle" id="sidebar-toggle" type="button"
        aria-label="Toggle sidebar" aria-expanded="false" aria-controls="side-bar">
        <span></span><span></span><span></span>
      </button>
    </div>
    <div class="header-right">
      <div class="searchbar">
        <input type="text" placeholder="Search exercise..." class="search-input">
        <img src="images/search.png" alt="Search" class="search">
      </div>
      <button class="header-icon programs" type="button">
        <img src="images/programs.png" alt="Programs">
      </button>
      <a href="library.php">
        <button class="header-icon exercise-library" type="button">
          <img src="images/Exercise library.png" alt="Exercise Library">
        </button>
      </a>
      <div class="account-menu-wrapper">
        <button class="header-icon account" id="account-toggle" type="button" aria-expanded="false" aria-haspopup="true" aria-label="Account menu">
          <img src="images/Account.png" alt="Account">
        </button>
        <div class="account-dropdown" id="account-dropdown" role="menu">
          <div class="account-dropdown-user">
            <span class="account-dropdown-username"><?= $safe_display ?></span>
          </div>
          <button class="account-dropdown-item" id="theme-toggle" type="button" role="menuitem">
            <span class="theme-toggle-icon" id="theme-toggle-icon" aria-hidden="true"></span>
            <span id="theme-toggle-label">Light Mode</span>
          </button>
          <button class="account-dropdown-item" id="lang-toggle" type="button" role="menuitem">
            <img src="images/ic_outline-language.png" alt="Language" class="dropdown-icon">
            <span id="lang-toggle-label">Română</span>
          </button>
          <button class="account-dropdown-item" id="contact-open" type="button" role="menuitem">
            <img src="images/mdi_contact.png" alt="Contact" class="dropdown-icon">
            <span>Contact</span>
          </button>
          <a href="logout.php" class="account-dropdown-item" role="menuitem">
            <img src="images/majesticons_logout.png" alt="Log out" class="dropdown-icon">
            <span>Log Out</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="main-content">

    <div class="side-bar">
      <button class="create-new-workout side-bar-button" id="btn-create-new">
        <img src="images/add.png" alt="Create New Workout">
        <p>Create New Workout</p>
      </button>
      <button class="my-workouts side-bar-button">
        <img src="images/workouts.png" alt="My Workouts">
        <p>My Workouts</p>
      </button>
      <div class="searchbar-sidebar">
        <input type="text" placeholder="Search workout..." class="sidebar-search-input" id="sidebar-search">
        <img src="images/search.png" alt="Search" class="search">
      </div>
      <div class="workout-list" id="workout-list"></div>
    </div>

    <div class="workout-area">

      <div class="empty-state" id="empty-state">
        <div class="empty-icon">
          <img src="images/add.png" alt="">
        </div>
        <p>Click <strong>Create New Workout</strong> to get started</p>
      </div>

      <div class="builder" id="builder" style="display:none;">
        <div class="builder-header">
          <input type="text" id="workout-title" class="workout-title-input" placeholder="Workout name..." maxlength="60">
          <button class="save-workout-btn" id="btn-save-workout">Save Workout</button>
        </div>
        <div class="exercise-list" id="exercise-list"></div>
        <button class="add-exercise-btn" id="btn-add-exercise">
          <span class="plus-icon">+</span> Add Exercise
        </button>
      </div>

    </div>
  </div>

  <!-- Exercise picker modal -->
  <div class="modal-overlay" id="modal-overlay" style="display:none;">
    <div class="modal" id="exercise-modal">
      <div class="modal-header">
        <span class="modal-title">Add Exercise</span>
        <button class="modal-close" id="modal-close">✕</button>
      </div>
      <div class="category-tabs" id="category-tabs">
        <button class="cat-tab active" data-file="exercises_abs">Abs</button>
        <button class="cat-tab" data-file="exercises_back">Back</button>
        <button class="cat-tab" data-file="exercises_biceps">Biceps</button>
        <button class="cat-tab" data-file="exercises_chest">Chest</button>
        <button class="cat-tab" data-file="exercises_legs">Legs</button>
        <button class="cat-tab" data-file="exercises_shoulders">Shoulders</button>
        <button class="cat-tab" data-file="exercises_triceps">Triceps</button>
      </div>
      <div class="modal-search-wrap">
        <input type="text" id="modal-search" placeholder="Search..." class="modal-search-input">
      </div>
      <div class="exercise-grid" id="exercise-grid">
        <p class="loading-text">Loading exercises...</p>
      </div>
    </div>
  </div>

  <!-- Contact modal -->
  <div class="contact-modal-overlay" id="contact-modal-overlay" aria-hidden="true">
    <div class="contact-modal" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
      <button class="contact-modal-close" id="contact-modal-close" type="button" aria-label="Close contact modal">×</button>
      <p class="contact-modal-eyebrow">Support</p>
      <h2 id="contact-modal-title">Contact us</h2>
      <p class="contact-modal-text">Need help with your workouts or the app? Send us a quick message and we'll get back to you soon.</p>
      <form class="contact-modal-form" id="contact-modal-form">
        <label>Full name<input type="text" name="name" placeholder="Your name" required></label>
        <label>Email<input type="email" name="email" placeholder="you@example.com" required></label>
        <label>Message<textarea name="message" rows="4" placeholder="Tell us how we can help..." required></textarea></label>
        <button class="contact-modal-submit" type="submit">Send message</button>
        <p class="contact-modal-status" id="contact-modal-status" aria-live="polite"></p>
      </form>
    </div>
  </div>

  <!-- Rest timer modal -->
  <div class="modal-overlay" id="timer-overlay" style="display:none;">
    <div class="modal timer-modal" id="timer-modal">
      <div class="modal-header">
        <span class="modal-title">Edit Rest Timer</span>
        <button class="modal-close" id="timer-close">✕</button>
      </div>
      <div class="timer-edit-body">
        <label class="timer-label">Minutes</label>
        <input type="number" id="timer-min-input" class="timer-number-input" min="0" max="10" value="1">
        <span class="timer-colon">:</span>
        <label class="timer-label">Seconds</label>
        <input type="number" id="timer-sec-input" class="timer-number-input" min="0" max="59" step="5" value="30">
      </div>
      <button class="save-timer-btn" id="save-timer-btn">Set Timer</button>
    </div>
  </div>
  <div class="sidebar-overlay" id="sidebar-overlay"></div>
  <script src="js/script.js"></script>
  <script src="js/workout.js"></script>
</body>
</html>