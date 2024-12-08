<?php
    include('../config/constants.php');

    // Check if the user is a superadmin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
        $_SESSION['delete'] = "<div class='error'>Access Denied. Only Superadmins can delete admins.</div>";
        header('location:' . HOMEURL . 'admin/manage-admin.php');
        exit;
    }

    // Get the ID of the admin to be deleted
    $a_id = $_GET['a_id'];

    // Check if the admin being deleted is a superadmin
    $sql_check_role = "SELECT a_role FROM tbl_admin WHERE a_id=$a_id";
    $res_check_role = mysqli_query($conn, $sql_check_role);

    if ($res_check_role == TRUE && mysqli_num_rows($res_check_role) == 1) {
        $row = mysqli_fetch_assoc($res_check_role);
        $a_role = $row['a_role'];

        if ($a_role === 'superadmin') {
            // Prevent deletion of a superadmin
            $_SESSION['delete'] = "<div class='error'>You cannot delete a superadmin.</div>";
            header('location:' . HOMEURL . 'admin/manage-admin.php');
            exit;
        }
    } else {
        $_SESSION['delete'] = "<div class='error'>Admin not found.</div>";
        header('location:' . HOMEURL . 'admin/manage-admin.php');
        exit;
    }

    // Proceed to delete if the admin is not a superadmin
    $sql = "DELETE FROM tbl_admin WHERE a_id=$a_id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin.</div>";
    }

    // Redirect to manage admin page
    header('location:' . HOMEURL . 'admin/manage-admin.php');
?>
