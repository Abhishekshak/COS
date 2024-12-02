<?php
include('config/constants.php');
include('frontend-partials/header.php');

// Check if the user is logged in
if (!isset($_SESSION['u_name'])) {
    header('location:' . HOMEURL . 'login.php');
    exit;
}

// Get user ID from session
$u_id = $_SESSION['u_id'];

// Retrieve user information from the database (optional, for displaying user info)
$sql_user = "SELECT * FROM tbl_users WHERE u_id = $u_id";
$res_user = mysqli_query($conn, $sql_user);
$row_user = mysqli_fetch_assoc($res_user);

// Retrieve orders placed by the user
$sql_orders = "SELECT tbl_order.o_id, tbl_order.o_quantity, tbl_order.o_delivery_location, tbl_order.o_delivery_date, tbl_order.o_total, tbl_order.o_status, tbl_cake.c_name, tbl_cake.c_image_name 
               FROM tbl_order 
               JOIN tbl_cake ON tbl_order.c_id = tbl_cake.c_id 
               WHERE tbl_order.u_id = $u_id";
$res_orders = mysqli_query($conn, $sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <h1>Welcome, <?php echo htmlspecialchars($row_user['u_name']); ?>!</h1>
        <p>Your order history and profile details are below.</p>
    </div>

    <div class="user-info">
        <div>
            <h3>Profile Information</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($row_user['u_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row_user['u_email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row_user['u_contact']); ?></p>
        </div>
    </div>

    <h2>Your Orders</h2><br>
    <?php if(isset($_SESSION['order'])){
            echo($_SESSION['order']);
            unset($_SESSION['order']);}
    ?>
    <?php if (mysqli_num_rows($res_orders) > 0): ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Cake</th>
                    <th>Quantity</th>
                    <th>Delivery Location</th>
                    <th>Delivery Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_order = mysqli_fetch_assoc($res_orders)): ?>
                    <tr>
                        <td><?php echo $row_order['o_id']; ?></td>
                        <td>
                            <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $row_order['c_image_name']; ?>" alt="Cake Image">
                            <div><?php echo htmlspecialchars($row_order['c_name']); ?></div>
                        </td>
                        <td><?php echo $row_order['o_quantity']; ?></td>
                        <td><?php echo htmlspecialchars($row_order['o_delivery_location']); ?></td>
                        <td><?php echo $row_order['o_delivery_date']; ?></td>
                        <td class="total-price">$<?php echo number_format($row_order['o_total'], 2); ?></td>
                        <td>
                            <button class="view-status-btn"><?php echo $row_order['o_status']; ?></button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found!</p>
    <?php endif; ?>
</div>

<?php include('frontend-partials/footer.php'); ?>

</body>
</html>
