<?php
    include('../config/constants.php');

    
    echo $id = $_GET['id'];

    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    $res = mysqli_query($conn,$sql);

    if($res == TRUE){
        $_SESSION['delete'] = "Admin Deleted Sucessfully.";
        //redirecting to manage admin
        header('location:'.HOMEURL.'admin/manage-admin.php');
    }else{
        $_SESSION['delete'] = "Failed to Delete Admin.";
        header('location:'.HOMEURL.'admin/manage-admin.php');
    }