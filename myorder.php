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

// Check if the user data was retrieved successfully
if ($res_user && mysqli_num_rows($res_user) > 0) {
    $row_user = mysqli_fetch_assoc($res_user);
} else {
    $row_user = null; // If no user data is found, set to null
}

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
        <h1>Welcome, <?php echo ($row_user && isset($row_user['u_name'])) ? htmlspecialchars($row_user['u_name']) : 'Guest'; ?>!</h1>
        <p>Your order history and profile details are below.</p>
    </div>

    <div class="user-info">
        <div>
            <h3>Profile Information</h3>
            <p><strong>Username:</strong> <?php echo ($row_user && isset($row_user['u_name'])) ? htmlspecialchars($row_user['u_name']) : 'Not Available'; ?></p>
            <p><strong>Email:</strong> <?php echo ($row_user && isset($row_user['u_email'])) ? htmlspecialchars($row_user['u_email']) : 'Not Available'; ?></p>
            <p><strong>Phone:</strong> <?php echo ($row_user && isset($row_user['u_contact'])) ? htmlspecialchars($row_user['u_contact']) : 'Not Available'; ?></p>
        </div>

        <!-- Edit Profile Button -->
        <div style="text-align: right;">
            <a href="profile.php" class="edit-profile-btn">Edit Profile</a>
        </div>
    </div>

    <h2>Your Orders</h2><br>
    <?php if(isset($_SESSION['order'])){
            echo($_SESSION['order']);
            unset($_SESSION['order']);}
    ?>
    <?php 
    // Retrieve orders placed by the user
    $sql_orders = "SELECT tbl_order.o_id, tbl_order.o_quantity, tbl_order.o_delivery_location, tbl_order.o_delivery_date, tbl_order.o_total, tbl_order.o_status, tbl_cake.c_name, tbl_cake.c_image_name 
    FROM tbl_order 
    JOIN tbl_cake ON tbl_order.c_id = tbl_cake.c_id 
    WHERE tbl_order.u_id = $u_id 
    ORDER BY tbl_order.o_id DESC";

    $res_orders = mysqli_query($conn, $sql_orders);
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
                        <td class="total-price">Rs.<?php echo number_format($row_order['o_total'], 2); ?></td>
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
