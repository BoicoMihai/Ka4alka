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
      <button>
        <img src="images/logo.png" alt="Logo" class="logo">
      </button>
      <p>Ka4alka</p>
    </div>

    <div class="header-right">
      <div class="searchbar">
        <input type="text" placeholder="Search exercise..." class="search-input">
        <img src="images/search.png" alt="Search" class="search">
      </div>

      <button class="header-icon programs">
        <img src="images/programs.png" alt="Programs">
      </button>

      <button class="header-icon exercise-library">
        <img src="images/Exercise library.png" alt="Exercise Library">
      </button>

      <button class="header-icon account">
        <img src="images/Account.png" alt="Account">
      </button>
    </div>
  </header>

  <div class="main-content">
    <div class="side-bar">
      <button class="create-new-workout side-bar-button">
        <img src="images/add.png" alt="Create New Workout">
        <p>Create New Workout</p>
      </button>

      <button class="my-workouts side-bar-button">
        <img src="images/workouts.png" alt="My Workouts">
        <p>My Workouts</p>
      </button>
 
      <div class="searchbar-sidebar">
        <input type="text" placeholder="Search workout..." class="siderbar-search-input">
        <img src="images/search.png" alt="Search" class="search">
      </div>
    </div>

    <div class="boxes">
      <div class="empty-workout main-containers">
        <button>
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

      <div class="workouts-main main-containers">
        <button>
          <img src="images/more.png" alt="Add" class="more-image">
          <p>My Workoutst</p>
          <img src="images/workouts.png" alt="Programs" class="main-button">
        </button>
      </div>
    </div> 
  </div>
</body>
</html>