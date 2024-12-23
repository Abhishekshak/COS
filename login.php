<?php include('config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cake Ordering System</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Function to handle login success or failure
        function showPopup(message) {
            const popup = document.getElementById('popup');
            document.getElementById('popup-message').innerText = message;
            popup.style.display = 'block';
        }

        function tryAgain() {
            window.location.href = 'login.php';
        }
    </script>
</head>
<body style="background-color: #9ed4c4">
    <h1 class="text-white">Login - Cake Ordering System</h1>
    <?php if(isset($_SESSION['register'])){
        echo $_SESSION['register'];
        unset($_SESSION['register']); }
    ?><br>
    <!-- Login Form -->
    <form action="" method="POST">
        <div class="inputs">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="inputs">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <input class="btn" name="submit" type="submit" value="LOGIN">
    </form>

    <!-- Add Register link -->
    <p class="text-white" style="text-align: center;">
        Don't have an account? <a href="register.php" style="color: #007b5e; text-decoration: none;">Sign up</a>
    </p>

    <!-- Popup Dialog -->
    <div id="popup" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background-color:white; padding:20px; border-radius:10px; box-shadow:0px 0px 10px rgba(0,0,0,0.2); text-align:center;">
        <p id="popup-message"></p>
        <button onclick="tryAgain()" style="padding:10px 20px; background-color:#007b5e; color:white; border:none; border-radius:5px; cursor:pointer;">Try Again</button>
    </div>

    <?php 
    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // MD5 hashing for the password
        $hashed_password = md5($password);

        // Check if email and password match any record in the database
        $sql = "SELECT * FROM tbl_users WHERE u_email='$email' AND u_password='$hashed_password'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            // Successful login, set session variables
            $user = mysqli_fetch_assoc($res);
            $_SESSION['u_name'] = $user['u_name']; // Store the username in session
            $_SESSION['u_id'] = $user['u_id']; // Store the user ID in session if needed

            // Redirect to the homepage or a dashboard after login
            header('Location: index.php');
            exit;
        } else {
            // Login failed, show error
            echo "<script>showPopup('Invalid email or password. Please try again.');</script>";
        }
    }
    ?>
</body>
</html>
