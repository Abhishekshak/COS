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
            $sql = "SELECT * FROM tbl_admin";
            $res = mysqli_query($conn, $sql);
            if ($res == TRUE) {
                //counting rows 
                $count = mysqli_num_rows($res);
                $sn = 1;
                if ($count > 0) {
                    //we got data in db
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['id'];
                        $username = $rows['username'];
                        $role = $rows['role'];  // Assume 'role' column is added to tbl_admin
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo ucfirst($role); ?></td>

                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superadmin') : ?>
                                <td>
                                    <!-- Update Admin option available for all -->
                                    <a href="<?php echo HOMEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>

                                    <!-- Allow deletion only if it's not a superadmin -->
                                    <?php if ($role !== 'superadmin') : ?>
                                        <a href="<?php echo HOMEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
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

<?php include('partials/footer.php'); ?>
