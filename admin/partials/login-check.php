<?php
    //authorization a/c
    if(!isset($_SESSION['user'])){
        //usernotlogged in 
        //so redirecting to login page 
        $_SESSION['no-login-message'] = "<div class= 'error'>Please login to access Admin Panel.</div>";
        header('location:'.HOMEURL.'admin/login.php');
    }
?>