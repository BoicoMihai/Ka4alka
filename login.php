<?php require("login_class.php");?>

<?php
    if(isset($_POST['submit'])){
        $user = new LoginUser($_POST['username'] ?? $_POST['email'] ?? '', $_POST['password'] ?? '');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link rel="stylesheet" href="css/register_login.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-wrapper">
            <div class="modal" role="dialog" aria-labelledby="loginTitle">
                <h2 id="loginTitle">Login</h2>

                <form id="loginForm" class="signup-form" action="" method="post" autocomplete="off">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" name="submit" class="modal-submit">Login</button>

                    <p class="modal-switch-text">
                        Don't have an account? <a href="register.php">Sign Up</a>
                    </p>

                    <p class="error"><?php echo @$user->error ?></p>
                    <p class="success"><?php echo @$user->success ?></p>
                </form>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>