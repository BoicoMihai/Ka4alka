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

  <header class="header">
  <div class="header-left">
    <a href="index.php">
      <button type="button">
        <img src="images/logo.png" alt="Logo" class="logo">
      </button>
    </a>
    <p>Ka4alka</p>
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
        <button class="account-dropdown-item" id="theme-toggle" type="button" role="menuitem">
          <span class="theme-toggle-icon" id="theme-toggle-icon" aria-hidden="true"></span>
          <span id="theme-toggle-label">Light Mode</span>
        </button>
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

      <!-- Builder (hidden until Create clicked) -->
      <div class="builder" id="builder" style="display:none;">

        <!-- Workout title row -->
        <div class="builder-header">
          <input type="text" id="workout-title" class="workout-title-input" placeholder="Workout name..." maxlength="60" >
          <button class="save-workout-btn" id="btn-save-workout">Save Workout</button>
        </div>

        <!-- Exercise cards list -->
        <div class="exercise-list" id="exercise-list"></div>

        <!-- Add exercise button -->
        <button class="add-exercise-btn" id="btn-add-exercise">
          <span class="plus-icon">+</span> Add Exercise
        </button>

      </div>
    </div>
  </div>

  <!-- ═══ EXERCISE PICKER MODAL ═══ -->
  <div class="modal-overlay" id="modal-overlay" style="display:none;">
    <div class="modal" id="exercise-modal">
      <div class="modal-header">
        <span class="modal-title">Add Exercise</span>
        <button class="modal-close" id="modal-close">✕</button>
      </div>

      <!-- Category tabs -->
      <div class="category-tabs" id="category-tabs">
        <button class="cat-tab active" data-file="exercises_abs">Abs</button>
        <button class="cat-tab" data-file="exercises_back">Back</button>
        <button class="cat-tab" data-file="exercises_biceps">Biceps</button>
        <button class="cat-tab" data-file="exercises_chest">Chest</button>
        <button class="cat-tab" data-file="exercises_legs">Legs</button>
        <button class="cat-tab" data-file="exercises_shoulders">Shoulders</button>
        <button class="cat-tab" data-file="exercises_triceps">Triceps</button>
      </div>

      <!-- Search inside modal -->
      <div class="modal-search-wrap">
        <input type="text" id="modal-search" placeholder="Search..." class="modal-search-input">
      </div>

      <!-- Exercise grid -->
      <div class="exercise-grid" id="exercise-grid">
        <p class="loading-text">Loading exercises...</p>
      </div>
    </div>
  </div>

  <!-- ═══ REST TIMER EDIT MODAL ═══ -->
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

  <script src="js/workout.js"></script>
  <script src="js/script.js"></script>
</body>
</html>