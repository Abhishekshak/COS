<?php include ('partials/menu.php'); ?>

<!-- main section starts-->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <?php
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>
        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>

        <br><br>

        <!-- button to add admin, visible only to superadmin -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') : ?>
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>
        <?php endif; ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Username</th>
                <th>Role</th>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') : ?>
                    <th>Actions</th>  <!-- Only show the Actions column for superadmins -->
                <?php endif; ?>
            </tr>

            <?php
            $sql = "SELECT * FROM tbl_admin"; // Query remains the same, fetching all admin records
            $res = mysqli_query($conn, $sql);
            if ($res == TRUE) {
                //counting rows 
                $count = mysqli_num_rows($res);
                $sn = 1;
                if ($count > 0) {
                    //we got data in db
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $a_id = $rows['a_id'];
                        $a_username = $rows['a_username'];
                        $a_role = $rows['a_role'];  // Updated for the new attribute names
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $a_username; ?></td>
                            <td><?php echo ucfirst($a_role); ?></td>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') : ?>
                                <td>
                                    <!-- Update Admin option available for all -->
                                    <a href="<?php echo HOMEURL; ?>admin/update-admin.php?a_id=<?php echo $a_id; ?>" class="btn-secondary">Update Admin</a>

                                    <!-- Allow deletion only if it's not a superadmin -->
                                    <?php if ($a_role !== 'superadmin') : ?>
                                        <a href="#" onclick="confirmDelete('<?php echo HOMEURL; ?>admin/delete-admin.php?a_id=<?php echo $a_id; ?>')" class="btn-danger">Delete Admin</a>
                                    <?php else : ?>
                                        <span class="btn-disabled">Superadmin</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                    }
                } else {
                    // No data found in db
                    echo "<tr><td colspan='4'>No Admins Found</td></tr>";
                }
            }
            ?>
        </table>

    </div>
</div>
<!-- main section ends-->

<script>
    function confirmDelete(url) {
        // Display the confirmation popup
        if (confirm("Are you sure you want to delete this admin?")) {
            // If confirmed, redirect to the delete URL
            window.location.href = url;
        } else {
            // If cancelled, do nothing
            return false;
        }
    }
</script>

<?php include('partials/footer.php'); ?>
