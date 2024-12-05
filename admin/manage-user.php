
<?php
    include('partials/menu.php');
    // Check if the admin is logged in (you can replace this with your actual admin authentication logic)
    // if (!isset($_SESSION['u_name']) || $_SESSION['u_name'] != 'admin') {
    //     header('Location: login.php'); // Redirect to login if not an admin
    //     exit;
    // }

    // Fetch all users from the database
    $sql = "SELECT * FROM tbl_users";
    $res = mysqli_query($conn, $sql);
?>


    <div class="main-content">

    
    <div class="wrapper">
        <h1>Registered Users</h1>
        <br><br>
        <?php
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
        ?>
        <table class = "tbl-full">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php 
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "
                        <tr>
                            <td>" . $row['u_id'] . "</td>
                            <td>" . $row['u_name'] . "</td>
                            <td>" . $row['u_contact'] . "</td>
                            <td>" . $row['u_address'] . "</td>
                            <td>" . $row['u_email'] . "</td>
                            <td>
                                <a href='delete-user.php?id=" . $row['u_id'] . "' class='btn-danger'>Delete User</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found.</td></tr>";
                }
            ?>
        </table>
    </div>
    </div>
</html>
<?php include('partials/footer.php'); ?>
