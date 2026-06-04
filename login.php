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
    <link rel="stylesheet" href="css/test.css">
</head>
<body>
    <div class="auth-container">
        <div class="form-wrapper">
           
            <form id="loginForm" class="auth-form active" action="" method="post" autocomplete="off">
                <h2>Login</h2>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="submit" class="btn-primary">Login</button>

                <p class="form-footer">
                    Don't have an account? 
                    <a href="register.php">Sign Up</a>
                </p>

                <p class="error"><?php echo @$user->error ?></p>
                <p class="success"><?php echo @$user->success ?></p>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>