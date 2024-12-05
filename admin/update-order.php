<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order Status</h1>
        <br><br>

        <?php
        if (isset($_GET['o_id'])) {
            $o_id = $_GET['o_id'];

            // Get order details from database
            $sql = "SELECT o.o_id, o.o_status, u.u_name, c.c_name
                    FROM tbl_order o
                    JOIN tbl_users u ON o.u_id = u.u_id
                    JOIN tbl_cake c ON o.c_id = c.c_id
                    WHERE o.o_id=$o_id";

            $res = mysqli_query($conn, $sql);

            if ($res == TRUE && mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_assoc($res);

                $u_name = $row['u_name'];
                $c_name = $row['c_name'];
                $o_status = $row['o_status'];
            } else {
                $_SESSION['update'] = "<div class='error'>Order Not Found.</div>";
                header('location:' . HOMEURL . 'admin/manage-order.php');
            }
        } else {
            header('location:' . HOMEURL . 'admin/manage-order.php');
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>User Name:</td>
                    <td><?php echo $u_name; ?></td>
                </tr>
                <tr>
                    <td>Cake Name:</td>
                    <td><?php echo $c_name; ?></td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="o_status">
                            <option <?php if ($o_status == "Pending") echo "selected"; ?> value="Pending">Pending</option>
                            <option <?php if ($o_status == "Processing") echo "selected"; ?> value="Processing">Processing</option>
                            <option <?php if ($o_status == "Delivered") echo "selected"; ?> value="Delivered">Delivered</option>
                            <option <?php if ($o_status == "Cancelled") echo "selected"; ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="o_id" value="<?php echo $o_id; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $o_id = $_POST['o_id'];
            $o_status = $_POST['o_status'];

            // Update order status in database
            $sql2 = "UPDATE tbl_order SET o_status='$o_status' WHERE o_id=$o_id";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == TRUE) {
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
            }
            header('location:' . HOMEURL . 'admin/manage-order.php');
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
