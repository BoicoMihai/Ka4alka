<?php require_once __DIR__ . '/session_user.php'; ?>
<?php
$muscle = $_GET['muscle'] ?? 'chest';
$exercises = json_decode(file_get_contents(__DIR__ . "/data/exercises_{$muscle}.json"), true);
$activeFilter = $_GET['category'] ?? 'all';

$filtered = array_filter($exercises, function($ex) use ($activeFilter) {
  return $activeFilter === 'all' || strtolower($ex['category']) === strtolower($activeFilter);
});
$filtered = array_values($filtered);

$perPage = 30;
$totalPages = max(1, ceil(count($filtered) / $perPage));
$currentPage = max(1, min((int)($_GET['page'] ?? 1), $totalPages));
$offset = ($currentPage - 1) * $perPage;
$pageExercises = array_slice($filtered, $offset, $perPage);

$muscles = ['chest', 'shoulders', 'biceps', 'legs', 'Back', 'Abs', 'triceps'];
$currentIndex = array_search($muscle, $muscles);
$nextMuscle = $muscles[$currentIndex + 1] ?? $muscles[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exercise Library – Ka4alka</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/library.css">

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
          <div class="search-dropdown" id="search-dropdown"></div>  <!-- ADD THIS -->
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

    <div class="library-content">

      <div class="filter-bar">
        <div class="filter-trigger" id="filter-toggle">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M1 2h12M3 7h8M5 12h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
          <span>Filter</span>
          <svg class="filter-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <div class="filter-chips" id="filter-chips">
          <?php
          $categories = [
            ['value' => 'all',         'label' => 'All',         'icon' => ''],
            ['value' => 'dumbbell',    'label' => 'Dumbbell',    'icon' => 'images/streamline-plump_dumbell.png'],
            ['value' => 'body weight', 'label' => 'Body weight', 'icon' => 'images/ion_body.png'],
            ['value' => 'machine',     'label' => 'Machines',    'icon' => 'images/Vector.png'],
          ];
          foreach ($categories as $cat):
            $isActive = $activeFilter === $cat['value'];
          ?>
            <a href="?muscle=<?= urlencode($muscle) ?>&category=<?= urlencode($cat['value']) ?>"
               class="filter-chip <?= $isActive ? 'active' : '' ?>">
              <?php if (!empty($cat['icon'])): ?>
                <img class="chip-icon" src="<?= $cat['icon'] ?>" alt="<?= htmlspecialchars($cat['label']) ?>">
              <?php endif; ?>
              <?= htmlspecialchars($cat['label']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

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

  <div class="pagination">
    <?php foreach ($muscles as $i => $m): ?>
      <a href="?muscle=<?= $m ?>" class="page-btn <?= $muscle === $m ? 'active' : '' ?>">
        <?= $i + 1 ?>
      </a>
    <?php endforeach; ?>
    <a href="?muscle=<?= $nextMuscle ?>" class="page-btn next">next</a>
  </div>

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
  <div class="sidebar-overlay" id="sidebar-overlay"></div>
  <script src="js/script.js"></script>
</body>
</html>