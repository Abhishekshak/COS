<?php
    include('../config/constants.php');
    // Checking if id and image_name are set in the URL
    if (isset($_GET['c_id']) AND isset($_GET['c_image_name'])) {
        // Get the cake id and image name
        $c_id = $_GET['c_id'];
        $c_image_name = $_GET['c_image_name'];

        // If image name is not empty, remove the image from the local storage
        if ($c_image_name != "") {
            // Image path
            $path = "../img/cake/" . $c_image_name;
            // Remove the image
            $remove = unlink($path);
            // If failed to remove image, set an error message and redirect
            if ($remove == FALSE) {
                $_SESSION['remove'] = "<div class='error'>Failed to remove Cake Image</div>";
                header('location:' . HOMEURL . 'admin/manage-cake.php');
                die();
            }
        }

        // SQL query to delete the cake
        $sql = "DELETE FROM tbl_cake WHERE c_id=$c_id";  // Use c_id as the primary key

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check if the deletion was successful
        if ($res == TRUE) {
            $_SESSION['delete'] = "<div class='success'>Cake removed successfully.</div>";
            header('location:' . HOMEURL . 'admin/manage-cake.php');
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to remove cake.</div>";
            header('location:' . HOMEURL . 'admin/manage-cake.php');
        }
    } else {
        // Redirect to manage cake if id or image_name is not set
        header('location:' . HOMEURL . 'admin/manage-cake.php');
    }
?>
