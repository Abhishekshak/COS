<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><br>

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Cake Name</th>
                <th>Quantity</th>
                <th>Delivery Location</th>
                <th>Delivery Date</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT 
                        o.o_id, o.o_quantity, o.o_status, 
                        o.o_delivery_location, o.o_delivery_date, o.o_total,
                        u.u_name, c.c_name, c.c_image_name
                    FROM tbl_order o
                    JOIN tbl_users u ON o.u_id = u.u_id
                    JOIN tbl_cake c ON o.c_id = c.c_id 
                    ORDER BY o.o_delivery_date DESC";

            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $o_id = $row['o_id'];
                        $u_name = $row['u_name'];
                        $c_name = $row['c_name'];
                        $o_quantity = $row['o_quantity'];
                        $o_delivery_location = $row['o_delivery_location'];
                        $o_delivery_date = $row['o_delivery_date'];
                        $o_total = $row['o_total'];
                        $o_status = $row['o_status'];
                        ?>
                        <tr>
                            <td><?php echo $o_id; ?></td>
                            <td><?php echo $u_name; ?></td>
                            <td><?php echo $c_name; ?></td>
                            <td><?php echo $o_quantity; ?></td>
                            <td><?php echo $o_delivery_location; ?></td>
                            <td><?php echo $o_delivery_date; ?></td>
                            <td>Rs. <?php echo $o_total; ?></td>
                            <td>
                                <span class="badge <?php echo strtolower($o_status); ?>">
                                    <?php echo ucfirst($o_status); ?>
                                </span>
                            </td>
                            <td>
                                <a href="update-order.php?o_id=<?php echo $o_id; ?>" class="btn-secondary">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='9'>No Orders Found</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
