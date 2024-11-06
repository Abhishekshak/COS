<?php include('../config/constants.php') ?>
<html>



    <head>
        <title>Login</title>
        <link rel="stylesheet" href="admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body style="background-color : #9ed4c4">
        <div class="login text-center">
             <h1 class= "text-white">Login - COS</h1>
            <br>
             <?php 
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])){
                    echo  $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
             ?>
             <br>
                <form action="" method= "POST">
                    <div class="inputs"><i class="fas fa-user"></i><input type="text" name = "username" placeholder="Username"></div>
                    <div class="inputs"><i class="fas fa-lock"></i><input type="password" name = "password" placeholder="Password"></div>
                    <input class= "btn" name= "submit" type="submit" value="LOGIN" >
                </form>
            <br>
            <br>
            <p class= "text-white">
                Created by Abhishek Shakya
            </p>
        </div>
    </body>
</html>


<?php 
    if(isset($_POST['submit'])){
       $username = $_POST['username'];
       $password = md5($_POST['password']);

       $sql = "SELECT *from tbl_admin where username = '$username' AND password = '$password'";

       $res = mysqli_query($conn,$sql);


       //counting rows to check whether user exits or not 
       $count = mysqli_num_rows($res);
       if($count == 1){
            $_SESSION['login'] = "<div class= 'success'>Login Successfull.</div>";
            $_SESSION['user'] = $username; //checking if user is logged in or not and log out in menu.php
            header('location:'.HOMEURL.'admin/');
            //user exists successfull
       }else{
        //no user exits 
        $_SESSION['login'] = "<div class = 'error'>Credentials not matched.</div>";
        header('location:'.HOMEURL.'admin/login.php');
       }
    }
?>