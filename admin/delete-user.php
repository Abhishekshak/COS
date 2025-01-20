<?php
    include('../config/constants.php');  // Include database connection

    // Check if 'id' is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Mark the user as deleted (soft delete)
        $sql = "UPDATE tbl_users SET is_deleted = 1 WHERE u_id = '$id'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['delete'] = "<div class='success'>User deleted successfully.</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to mark user as deleted. Please try again.</div>";
        }

        // Redirect back to the admin users page
        header('Location: manage-user.php');
    } else {
        // Redirect if ID is not provided
        header('Location: manage-user.php');
    }
?>
