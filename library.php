<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/library.css">
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
      <a href="library.php">
        <button class="header-icon exercise-library">
          <img src="images/Exercise library.png" alt="Exercise Library">
        </button>
      </a>
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
    <!-- ↑ sidebar ends here -->

    <!-- ↓ main area starts here -->
    <div class="library-content">
      <?php
        $exercises = json_decode(file_get_contents('data/exercises.json'), true);
        $activeFilter = $_GET['category'] ?? 'all';
      ?>

      <div class="exercise-grid">
        <?php foreach ($exercises as $ex): ?>
          <?php if ($activeFilter === 'all' || strtolower($ex['category']) === strtolower($activeFilter)): ?>
            <div class="exercise-card" data-category="<?= htmlspecialchars($ex['category']) ?>">
              <img class="card-image" src="<?= htmlspecialchars($ex['image']) ?>" alt="<?= htmlspecialchars($ex['name']) ?>">
              <div class="card-body">
                <p class="card-name"><?= htmlspecialchars($ex['name']) ?></p>
                <div class="card-tags">
                  <?php foreach ($ex['tags'] as $tag): ?>
                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                  <?php endforeach; ?>
                </div>
                <a class="card-btn" href="<?= htmlspecialchars($ex['url']) ?>" target="_blank">
                  More details <span class="arrow">›</span>
                </a>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

    </div>

  </div>
</body>
</html>