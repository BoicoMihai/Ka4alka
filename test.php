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
</head>
<body>
    <div class="auth-container">
        <div class="form-wrapper">
           
            <form id="loginForm" class="auth-form active">
                <h2>Login</h2>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-primary">Login</button>

                <p class="form-footer">
                    Don't have an account? 
                    <a href="#" id="toggleSignup">Sign Up</a>
                </p>
            </form>

            
            <form id="signupForm" class="auth-form <?= (isset($user) && !empty($user->error ?? '') || !empty($user->success ?? '')) ? 'active' : '' ?>" method="post" autocomplete="off">
                <h2>Create Account</h2>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="signup_email">Email</label>
                    <input type="email" id="signup_email" name="signup_email" value="<?= isset($_POST['signup_email']) ? htmlspecialchars($_POST['signup_email']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="signup_password">Password</label>
                    <input type="password" id="signup_password" name="signup_password" required>
                    <small>Minimum 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" name="submit_signup" class="btn-primary">Sign Up</button>

                <p class="form-footer">
                    Already have an account? 
                    <a href="#" id="toggleLogin">Login</a>
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

    <script src="js/script.js"></script>
</body>
</html>