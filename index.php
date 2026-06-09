<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
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
    <a href="logout.php" class="account-dropdown-item" role="menuitem">
        <span class="theme-toggle-icon"></span>
        <span>Log Out</span>
    </a>
</div>
    </div>
  </div>
</header>

  <div class="main-content">
    <div class="side-bar">
    <button class="create-new-workout side-bar-button" onclick="location.href='new_workout.php'">
        <img src="images/add.png" alt="Create New Workout">
        <p>Create New Workout</p>
    </button>
    <button class="my-workouts side-bar-button">
        <img src="images/workouts.png" alt="My Workouts">
        <p>My Workouts</p>
    </button>
    <div class="searchbar-sidebar">
        <input type="text" placeholder="Search workout..." id="sidebar-search">
        <img src="images/search.png" alt="Search" class="search">
    </div>
    <div class="workout-list" id="workout-list"></div>
</div>

    <div class="boxes">
      <div class="empty-workout main-containers">
        <button onclick="location.href='new_workout.php'">
          <img src="images/add.png" alt="Add" class="main-button">
          <p>Start Empty Workout</p>
          <img src="images/Programs.png" alt="Programs" class="main-button">
        </button>
      </div>

      <p id="Routines-text">Routines</p>

      <div class="explore-workouts main-containers">
        <button>
          <img src="images/more.png" alt="Add" class="more-image">
          <p>Explore Workout</p>
          <img src="images/Folder.png" alt="Programs" class="main-button">
        </button>
      </div>

      <div class="workouts-main main-containers expandable" id="my-workouts-main">
        <button type="button" id="my-workouts-toggle">
          <img src="images/more.png" alt="Add" class="more-image" id="my-workouts-chevron">
          <p>My Workouts</p>
          <img src="images/workouts.png" alt="Programs" class="main-button">
        </button>
        <div class="main-workout-dropdown" id="main-workout-dropdown">
        </div>
      </div>
    </div> 
  </div>
  <script src="js/script.js"></script>
  <script src="js/workout.js"></script>
</body>
</html>