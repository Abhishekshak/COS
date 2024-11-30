<?php
    include('config/constants.php');  // Include config file where session is started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - COS</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="background-color: #9ed4c4;">
    <h1 class="text-white">Register - Cake Ordering System</h1>

    <form action="" method="POST">
        <div class="inputs">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="inputs">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="inputs">
            <i class="fas fa-phone"></i>
            <input type="text" name="contact" placeholder="Contact Number" required>
        </div>
        <div class="inputs">
            <i class="fas fa-home"></i>
            <input type="text" name="address" placeholder="Address" required>
        </div>
        <div class="inputs">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <input class="btn" name="submit" type="submit" value="Register">
    </form>

    <!-- Add Login link -->
    <p class="text-white" style="text-align: center;">
        Already a user? <a href="login.php" style="color: #007b5e; text-decoration: none;">Login now</a>
    </p>

    <p class="text-white" style="text-align: center;">
        Created by Abhishek Shakya
    </p>

</body>
</html>
