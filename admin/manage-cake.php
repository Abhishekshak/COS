<?php include('partials/menu.php'); ?>

<!-- main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Cake</h1>
        <br><br>

        <!-- button to add cake -->
        <a href="<?php echo HOMEURL; ?>admin/add-cake.php" class="btn-primary">Add Cake</a>
        <br><br><br>

        <?php
        // Display session messages (if any)
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['no-cake-found'])) {
            echo $_SESSION['no-cake-found'];
            unset($_SESSION['no-cake-found']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        ?>
        <br>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // SQL query to retrieve all cake details
            $sql = "SELECT * FROM tbl_cake ORDER BY c_id DESC";  // Ordering by c_id in descending order
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            $sn = 1; // Serial number counter
            if ($count > 0) {
                // Cakes are available
                while ($row = mysqli_fetch_assoc($res)) {
                    $c_id = $row['c_id'];                  // Changed from 'id' to 'c_id'
                    $c_name = $row['c_name'];              // Changed from 'title' to 'c_name'
                    $c_price = $row['c_price'];            // Changed from 'price' to 'c_price'
                    $c_image_name = $row['c_image_name'];  // Changed from 'image_name' to 'c_image_name'
                    $c_featured = $row['c_featured'];      // Changed from 'featured' to 'c_featured'
                    $c_active = $row['c_active'];          // Changed from 'active' to 'c_active'
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo htmlspecialchars($c_name); ?></td>
                        <td>Rs. <?php echo number_format($c_price); ?></td>
                        <td>
                            <?php
                            if ($c_image_name == "") {
                                echo "<div class='error'>No Image Found</div>";
                            } else {
                                ?>
                                <img src="<?php echo HOMEURL; ?>/img/cake/<?php echo $c_image_name; ?>" width="100px">
                                <?php
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($c_featured); ?></td>
                        <td><?php echo htmlspecialchars($c_active); ?></td>
                        <td>
                            <a href="<?php echo HOMEURL;?>admin/update-cake.php?c_id=<?php echo $c_id; ?>" class="btn-secondary">Update Cake</a>
                            <a href="#" onclick="confirmDelete('<?php echo HOMEURL; ?>admin/delete-cake.php?c_id=<?php echo $c_id; ?>&c_image_name=<?php echo $c_image_name; ?>')" class="btn-danger">Delete Cake</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No cakes in the database
                echo "<tr><td colspan='7' class='error'>Cakes not added yet.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<!-- main section ends -->

<script>
    function confirmDelete(url) {
        // Display the confirmation popup
        if (confirm("Are you sure you want to delete this cake?")) {
            // If confirmed, redirect to the delete URL
            window.location.href = url;
        } else {
            // If cancelled, do nothing
            return false;
        }
    }
</script>

<?php include('partials/footer.php'); ?>
