<?php
    include('partials/menu.php');
    // Fetch all users from the database
    $sql = "SELECT * FROM tbl_users ORDER BY u_id DESC";
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
        <br>
        <table class="tbl-full">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php 
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $is_deleted = $row['is_deleted']; // Check if the user is deleted
                        echo "
                        <tr>
                            <td>" . $row['u_id'] . "</td>
                            <td>" . $row['u_name'] . "</td>
                            <td>" . $row['u_contact'] . "</td>
                            <td>" . $row['u_address'] . "</td>
                            <td>" . $row['u_email'] . "</td>
                            <td>
                                " . ($is_deleted == 1 ? "<span class='deleted-user'>User Deleted</span>" : "<span class='active-user'>Active</span>") . "
                            </td>
                            <td>
                                " . ($is_deleted == 1 ? "<a href='restore-user.php?id=" . $row['u_id'] . "' class='btn-secondary' onclick=\"return confirmRestore();\">Restore User</a>" : "<a href='delete-user.php?id=" . $row['u_id'] . "' class='btn-danger' onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete User</a>") . "
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>
</html>
<?php include('partials/footer.php'); ?>

<script>
    // JavaScript confirmation for restoring user
    function confirmRestore() {
        return window.confirm('Are you sure you want to restore this user?');
    }
</script>
