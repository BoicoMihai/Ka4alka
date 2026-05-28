<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <div class="header">
       <button class ="button logo">
          <img src="images/logo.png" alt="logo">
       </button>

       <div class="search-bar">
         <input type="text" class="search-input" placeholder="Search exercises here...">
         <button class="button glass">
            <img src="images/Glass.png" alt="search">
         </button>
       </div>

       <img src="images/Line break.png" alt="line" class="line">

       <button class ="button library">
          <img src="images/Exercise library.png" alt="library">
       </button>

       <button class ="button programs">
          <img src="images/Programs.png" alt="programs">
       </button>

       <img src="images/Line break.png" alt="logo" class="line">

       <button class ="button light-dark_button">
          <img src="images/Light mode.png" alt="light/dark">
       </button>

       <button class ="button account">
          <img src="images/Account.png" alt="accunt">
       </button>
    </div>
  </header>

  <div class="side-menu">
    <div class="sidebar-button create">
      <button class="create">
        <img src="images/plus sign.png" alt="create">
       </button>
       <p>Create new workout routine</p>
    </div>

    <div class="sidebar-button workout">
      <button class="workout">
        <img src="images/MyWorkouts.png" alt="create">
       </button>
       <p>My workouts</p>
    </div>

    <div class="search-workout">
      <input type="text" class="search-workout-input" placeholder="Search workout">
    </div>

    <div class="workout-list">
      <div class="workout-item">Workout #1</div>
      <div class="workout-item">Workout #2</div>
    </div>

    <div class="collapse-btn">
      <button>❮</button>
    </div>
  </div>

  <div class="main-content">
    <section class="dashboard-section">
      <h2>Planned workout</h2>
      
      <div class="card">
        <span class="card-title">Create plan</span>
        <img src="images/copy-icon.png" alt="copy" class="card-icon">
      </div>

      <div class="card">
        <span class="card-title">Pre-made workouts</span>
        <img src="images/folder-icon.png" alt="folder" class="card-icon">
        <button class="dropdown-btn">▼</button>
      </div>
    </section>

    <section class="dashboard-section">
      <h2>Routines</h2>
      
      <div class="card">
        <span class="card-title">My routines (Number of routines in folder)</span>
        <img src="images/folder-icon.png" alt="folder" class="card-icon">
        <button class="dropdown-btn">▼</button>
      </div>
    </section>
  </div>

</body>
</html>
