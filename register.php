<?php
    include('config/constants.php');  // Include config file where session is started

    if (isset($_POST['submit'])) {
        // Get form data
        $username =  $_POST['username'];
        $password =  $_POST['password'];
        $contact =  $_POST['contact'];
        $address =  $_POST['address'];
        $email =  $_POST['email'];

        // Hash the password (you can choose a more secure hashing method like bcrypt if needed)
        $hashed_password = md5($password);

        // Check if email already exists in the database
        $email_check_query = "SELECT * FROM tbl_users WHERE u_email='$email'";
        $email_check_result = mysqli_query($conn, $email_check_query);

        if (mysqli_num_rows($email_check_result) > 0) {
            // Email already exists
            $_SESSION['register'] = "<div class='error'>Email is already registered. Please use a different email.</div>";
            header('location: register.php');
            exit;
        } else {
        // Insert data into the database if email is unique
        $sql = "INSERT INTO tbl_users (u_name, u_password, u_contact, u_address, u_email)
                VALUES ('$username', '$hashed_password', '$contact', '$address', '$email')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            // Registration successful, redirect to login page with a success message
            $_SESSION['register'] = "<div class='success'>Registration successful! Please log in.</div>";
            // echo "Session register message: " . $_SESSION['register']; 
            header('location: login.php');
            exit;
        } else {
            // Registration failed, show an error message
            $_SESSION['register'] = "<div class='error'>Failed to register. Please try again.</div>";
        }
    }
}
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
            <input type="tel" name="contact" placeholder="Contact Number" 
       pattern="\d{10}" maxlength="10" minlength="10" title="Contact number must be 10 digits" required>

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
        <?php if(isset($_SESSION['register'])){
        echo $_SESSION['register'];
        unset($_SESSION['register']); }
        ?>
    </form>

    <?php if(isset($_SESSION['register'])){
        echo $_SESSION['register'];
        unset($_SESSION['register']);}?>

    <!-- Add Login link -->
    <p class="text-white" style="text-align: center;">
        Already a user? <a href="login.php" style="color: #007b5e; text-decoration: none;">Login now</a>
    </p>

    <p class="text-white" style="text-align: center;">
        Created by Abhishek Shakya
    </p>

</body>
</html>
