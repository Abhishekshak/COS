<?php
include('config/constants.php');  // Include config file where session is started

// Ensure user is logged in
if (!isset($_SESSION['u_id'])) {
    header('location: login.php');
    exit;
}

// Fetch user data from the database
$user_id = $_SESSION['u_id']; // Assuming the user_id is stored in the session
$sql = "SELECT * FROM tbl_users WHERE u_id = '$user_id'";
$res = mysqli_query($conn, $sql);

if ($res) {
    $user = mysqli_fetch_assoc($res);
} else {
    $_SESSION['update'] = "<div class='error-msg'>User not found. Please try again.</div>";
}

// If form is submitted to update profile
if (isset($_POST['submit'])) {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    // Check if password is provided, if so, hash it
    if (!empty($password)) {
        $hashed_password = md5($password); // Use a more secure method like bcrypt if needed
    } else {
        $hashed_password = $user['u_password']; // Keep the existing password if not provided
    }

    // Update user data in the database
    $update_sql = "UPDATE tbl_users 
                   SET u_name = '$username', u_password = '$hashed_password', u_contact = '$contact', u_address = '$address', u_email = '$email'
                   WHERE u_id = '$user_id'";

    $update_res = mysqli_query($conn, $update_sql);

    if ($update_res) {
        $_SESSION['update'] = "<div class='success-msg'>Profile updated successfully!</div>";
    } else {
        $_SESSION['update'] = "<div class='error-msg'>Failed to update profile. Please try again.</div>";
    }

    // Redirect to the same page to avoid resubmitting the form on refresh
    // header('Location: profile.php');
    // exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Cake Ordering System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body style="background-color: #9ed4c4;">
<?php include 'frontend-partials/header.php'; ?>

<div class="profile">
    <h1>Edit Profile</h1>

    <!-- Show the update message if it exists -->
    <?php
    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']); // Unset the session variable after displaying the message
    }
    ?>

    <!-- Profile Edit Form -->
    <form action="" method="POST" class="profile-form">
        <div class="profile-inputs">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" value="<?php echo $user['u_name']; ?>" required>
        </div>

        <div class="profile-inputs">
            <i class="fas fa-lock"></i>
            <!-- Allow password to be optional -->
            <input type="password" name="password" placeholder="New Password (Leave empty to keep current)" value="">
        </div>

        <div class="profile-inputs">
            <i class="fas fa-phone"></i>
            <input type="tel" name="contact" placeholder="Contact Number" value="<?php echo $user['u_contact']; ?>" pattern="\d{10}" maxlength="10" minlength="10" title="Contact number must be 10 digits" required>
        </div>

        <div class="profile-inputs">
            <i class="fas fa-home"></i>
            <input type="text" name="address" placeholder="Address" value="<?php echo $user['u_address']; ?>" required>
        </div>

        <div class="profile-inputs">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" value="<?php echo $user['u_email']; ?>" required>
        </div>

        <input class="profile-btn" name="submit" type="submit" value="Update Profile">
    </form>
</div>

<?php include 'frontend-partials/footer.php'; ?>

</body>
</html>
