<?php 
    //start session
    session_start();



    //executing query and saving in db
    //creating constant to store non repeating value
    define('HOMEURL','http://localhost/COS/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','cos');
    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    // $conn = mysqli_connect('localhost','root','') or die(mysqli_error());
    // $db_select = mysqli_select_db($conn,'cos') or die(mysqli_error());
    
?>