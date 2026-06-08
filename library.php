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

    <div class="library-content">
      <?php
        $muscle = $_GET['muscle'] ?? 'chest';
        $exercises = json_decode(file_get_contents(__DIR__ . "/data/exercises_{$muscle}.json"), true);
        $activeFilter = $_GET['category'] ?? 'all';

        // Filter
        $filtered = array_filter($exercises, function($ex) use ($activeFilter) {
          return $activeFilter === 'all' || strtolower($ex['category']) === strtolower($activeFilter);
        });
        $filtered = array_values($filtered);

        // Pagination
        $perPage = 30;
        $totalPages = max(1, ceil(count($filtered) / $perPage));
        $currentPage = max(1, min((int)($_GET['page'] ?? 1), $totalPages));
        $offset = ($currentPage - 1) * $perPage;
        $pageExercises = array_slice($filtered, $offset, $perPage);
      ?>

      <div class="exercise-grid">
        <?php foreach ($pageExercises as $ex): ?>
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
        <?php endforeach; ?>
      </div>
    </div>

  </div>

 <?php
    $muscles = ['chest', 'shoulders', 'biceps', 'legs', 'Back', 'Abs', 'triceps'];
    $currentIndex = array_search($muscle, $muscles);
    $nextMuscle = $muscles[$currentIndex + 1] ?? $muscles[0];
    ?>

    <div class="pagination">
    <?php foreach ($muscles as $i => $m): ?>
        <a href="?muscle=<?= $m ?>" class="page-btn <?= $muscle === $m ? 'active' : '' ?>">
        <?= $i + 1 ?>
        </a>
  <?php endforeach; ?>
  <a href="?muscle=<?= $nextMuscle ?>" class="page-btn next">next</a>
</div>

  <script src="js/script.js"></script>
</body>
</html>