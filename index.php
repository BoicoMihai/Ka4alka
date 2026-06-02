<?php
session_start();

$errors = [
    'login'    => $_SESSION['login_error']    ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

// If user is logged in, don't show any modal; otherwise default to signup
$activeForm = (isset($_SESSION['name']) && isset($_SESSION['email'])) ? '' : ($_SESSION['active_form'] ?? 'register');

// Only unset the temporary flash keys — do NOT call session_unset()
// which would wipe the logged-in user's session data too
unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['active_form']);

function showError($error) {
    return !empty($error) ? "<p class='error-message'>" . htmlspecialchars($error) . "</p>" : "";
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

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

            <button class="header-auth signup">Sign Up</button>
            <button class="header-auth login">Log In</button>
        </div>
    </header>

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

    <div class="modal-overlay <?= isActiveForm('register', $activeForm) ?>" id="signup-modal">
        <div class="modal">
            <button class="modal-close" id="close-signup">&times;</button>
            <h2>Sign Up</h2>
            <?= showError($errors['register']) ?>
            <form class="signup-form" method="post" action="register.php">
                <label for="signup-email">Gmail</label>
                <input type="email" id="signup-email" name="email" placeholder="you@gmail.com" required>

                <label for="signup-username">Username</label>
                <input type="text" id="signup-username" name="username" placeholder="Choose a username" required>

                <label for="signup-password">Password</label>
                <input type="password" id="signup-password" name="password" placeholder="Enter password" required>

                <button type="submit" name="register" class="modal-submit">Create account</button>
                <p class="modal-switch-text">Already have an account? <a href="#" id="switch-to-login">Log in</a></p>
            </form>
        </div>
    </div>

    <div class="modal-overlay <?= isActiveForm('login', $activeForm) ?>" id="login-modal">
        <div class="modal">
            <button class="modal-close" id="close-login">&times;</button>
            <h2>Log In</h2>
            <?= showError($errors['login']) ?>
            <form class="login-form" method="post" action="login.php">
                <label for="login-email">Gmail</label>
                <input type="email" id="login-email" name="email" placeholder="you@gmail.com" required>

                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" placeholder="Enter password" required>

                <button type="submit" name="login" class="modal-submit">Log In</button>
                <p class="modal-switch-text">Don't have an account? <a href="#" id="switch-to-signup">Sign up</a></p>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>