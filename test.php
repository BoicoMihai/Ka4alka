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
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-wrapper">
            <div class="modal" role="dialog" aria-labelledby="loginTitle">
                <h2 id="loginTitle">Login</h2>

                <form id="loginForm" class="signup-form" method="post" autocomplete="off">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="modal-submit">Login</button>

                    <p class="modal-switch-text">
                        Don't have an account? <a href="#" id="toggleSignup">Sign Up</a>
                    </p>
                </form>
            </div>

            <div class="modal" role="dialog" aria-labelledby="signupTitle">
                <h2 id="signupTitle">Create Account</h2>

                <form id="signupForm" class="signup-form <?= (isset($user) && !empty($user->error ?? '') || !empty($user->success ?? '')) ? 'active' : '' ?>" method="post" autocomplete="off">
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

                    <p class="modal-switch-text">
                        Already have an account? <a href="#" id="toggleLogin">Login</a>
                    </p>

                    <?php if(isset($user) && !empty($user->error ?? '')): ?>
                        <p class="error"><?= htmlspecialchars($user->error) ?></p>
                    <?php endif; ?>

                    <?php if(isset($user) && !empty($user->success ?? '')): ?>
                        <p class="success"><?= htmlspecialchars($user->success) ?></p>
                    <?php endif; ?>

                </form>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>