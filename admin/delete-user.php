<?php
    include('../config/constants.php');  // Include database connection

    // Check if the admin is logged in
    // if (!isset($_SESSION['u_name']) || $_SESSION['u_name'] != 'admin') {
    //     header('Location: login.php'); // Redirect if not admin
    //     exit;
    // }

    // Check if 'id' is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Delete user from the database
        $sql = "DELETE FROM tbl_users WHERE u_id='$id'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>User deleted successfully.</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to delete user. Please try again.</div>";
        }

        // Redirect back to the admin users page
        header('Location: manage-user.php');
    } else {
        // Redirect if ID is not provided
        header('Location: manage-user.php');
    }
?>
