<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
    <br><br>

    <?php
        // Restrict access to superadmin only
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
            $_SESSION['no-access'] = "<div class='error'>Access Denied. Only Superadmin can add new admins.</div>";
            header('Location: manage-admin.php');
            exit;
        }

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
    ?>

    <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" placeholder="Enter your username" required></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" placeholder="Enter your password" required></td>
            </tr>
            <tr>
                <td>Role:</td>
                <td>
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
    </div>
</div>

<?php include('partials/footer.php')?>

<?php 
// Process the form and save the admin details in the database
if (isset($_POST['submit'])) {
    // Get data from form
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt the password using MD5
    $role = $_POST['role']; // Get the selected role

    // Query to insert data into the database
    $sql = "INSERT INTO tbl_admin (username, password, role) 
            VALUES ('$username', '$password', '$role')";
    
    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the data was inserted
    if ($res == TRUE) {
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully.</div>";
        // Redirect to Manage Admin page
        header("location:" . HOMEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin.</div>";
        // Redirect to Add Admin page
        header("location:" . HOMEURL . 'admin/add-admin.php');
    }
}
?>
