<?php
    include('../config/constants.php');

    // Check if the user is a superadmin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
        $_SESSION['delete'] = "<div class='error'>Access Denied. Only Superadmins can delete admins.</div>";
        header('location:' . HOMEURL . 'admin/manage-admin.php');
        exit;
    }

    // Get the ID of the admin to be deleted
    $id = $_GET['id'];

    // Check if the admin being deleted is a superadmin
    $sql_check_role = "SELECT role FROM tbl_admin WHERE id=$id";
    $res_check_role = mysqli_query($conn, $sql_check_role);

    if ($res_check_role == TRUE && mysqli_num_rows($res_check_role) == 1) {
        $row = mysqli_fetch_assoc($res_check_role);
        $role = $row['role'];

        if ($role === 'superadmin') {
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
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin.</div>";
    }

    // Redirect to manage admin page
    header('location:' . HOMEURL . 'admin/manage-admin.php');
?>
