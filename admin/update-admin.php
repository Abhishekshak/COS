<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>
        <br>

        <?php
            // Check if the admin ID is set
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                // Query to fetch the admin details from the database
                $sql = "SELECT * FROM tbl_admin WHERE id = $id";
                $res = mysqli_query($conn, $sql);

                // Check if the query returns a result
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    // Fetch admin details
                    $row = mysqli_fetch_assoc($res);
                    $username = $row['username'];
                    $password = $row['password'];
                } else {
                    // If no admin found with the given ID
                    $_SESSION['no-admin-found'] = "<div class='error'>Admin not found.</div>";
                    header("location:" . HOMEURL . 'admin/manage-admin.php');
                }
            } else {
                // Redirect if id is not provided in the URL
                header("location:" . HOMEURL . 'admin/manage-admin.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter your new password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Get data from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // If password is not entered, keep the old password
        if (empty($password)) {
            $password = $row['password']; // Keep the old password if no new password is provided
        } else {
            // Encrypt the password
            $password = md5($password); // md5 encrypts one side only
        }

        // Query to update the admin details
        $sql2 = "UPDATE tbl_admin SET username = '$username', password = '$password' WHERE id = $id";
        // Execute the query
        $res2 = mysqli_query($conn, $sql2);

        // Check if the update was successful
        if ($res2 == TRUE) {
            $_SESSION['update'] = "<div class='success'>Admin updated successfully.</div>";
            // Redirect to the manage-admin page
            header("location:" . HOMEURL . 'admin/manage-admin.php');
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to update admin.</div>";
            // Redirect back to the update-admin page
            header("location:" . HOMEURL . 'admin/update-admin.php?id=' . $id);
        }
    }
?>
