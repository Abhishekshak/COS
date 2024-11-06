
<?php
    include('../config/constants.php');
    // destroy session
    session_destroy(); //unsets user session 
    // redirecting to login paage
    header('location:'.HOMEURL.'admin/login.php');
?>