<?php 
    session_start();
    include('server.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register Page</title>
<link rel="stylesheet" href="style.css">

</head>
<body>
        <div class="header">
            <h2>Register</h2>
        </div>

        <form action="register_db.php" method="post">
            <?php include('errors.php'); ?>

            <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
            <?php endif ?>
            <div class="input-gruup">
            <label for="username">Username</label>
                <input type="text" name="username">
            </div>
            <div class="input-gruup">
                <label for="email">Email</label>
                <input type="email" name="email">
            </div>
            <div class="input-gruup">
                <label for="password_1">Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-gruup">
                <label for="password_2">Confirm Password</label>
                <input type="password" name="password_2">
            </div>

            <div class="input-gruup">
            <button type="submit" name="reg_user" class="btn">Register</button>
            </div>
                <p>Already a Member? <a href="login.php">Sign in</a></p>



        </form>

</body>
</html>