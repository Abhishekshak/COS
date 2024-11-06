<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
    <br>
    <br>
    <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                } 
    ?>
        <form action="" method ="POST">
            <table class= "tbl-30">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name = "username" placeholder = "Enter your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name = "password" placeholder = "Enter your password"></td>
                </tr>
                <tr>
                    <td colspan=2>
                        <input type="submit" name = "submit" value= "Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php')?>

<?php 
//process value from form and save in db
//check whether the submit button is clicked or not

if(isset($_POST['submit'])){
     //button clicked 
    //  echo 'button clicked';

    //get data from form
    $username = $_POST['username'];
    $password = md5($_POST['password']); //md5 encrypts one side only

    //query to keep in db 
    $sql = "INSERT INTO tbl_admin (username, password) 
            VALUES ('$username', '$password')";
    //executing query to store data in db
    $res = mysqli_query($conn,$sql) or die(mysqli_error());

    //checking
    if($res == TRUE){
        // echo 'data inserted';
        //using session
        $_SESSION['add'] = "Admin Added Sucessfully.";
        //redirect page to manage adminn
        header("location:".HOMEURL.'admin/manage-admin.php');
    }else{
        // echo 'failed to insert data';
        $_SESSION['add'] = "Failed to Add Admin.";
        //redirect page to add adminn
        header("location:".HOMEURL.'admin/add-admin.php');
    }
}
?>