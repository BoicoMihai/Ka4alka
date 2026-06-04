<?php
require("register_class.php");

if (isset($_POST['submit_signup'])) {
    $user = new RegisterUser(
        $_POST['signup_email'] ?? '',
        $_POST['signup_password'] ?? '',
        $_POST['confirm_password'] ?? null
    );

    if (!empty($user->success)) {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="test/logged_styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-wrapper"> 
            <div class="modal-overlay <?= (isset($user) && !empty($user->error ?? '') || !empty($user->success ?? '')) ? 'active' : 'active' ?>" id="signup-modal">
                <div class="modal">
                    <button class="modal-close" id="close-signup">&times;</button>
                    <h2>Create Account</h2>

                    <?php if(isset($user) && !empty($user->error ?? '')): ?>
                        <p class="error"><?= htmlspecialchars($user->error) ?></p>
                    <?php endif; ?>

                    <?php if(isset($user) && !empty($user->success ?? '')): ?>
                        <p class="success"><?= htmlspecialchars($user->success) ?></p>
                    <?php endif; ?>

                    <form id="signupForm" class="signup-form" method="post" autocomplete="off">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>

                        <label for="signup_email">Email</label>
                        <input type="email" id="signup_email" name="signup_email" value="<?= isset($_POST['signup_email']) ? htmlspecialchars($_POST['signup_email']) : '' ?>" required>

                        <label for="signup_password">Password</label>
                        <input type="password" id="signup_password" name="signup_password" required>
                        <small>Minimum 6 characters</small>

                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>

                        <button type="submit" name="submit_signup" class="modal-submit">Sign Up</button>
                    </form>

                    <p class="modal-switch-text">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>