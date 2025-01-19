<?php
include('config/constants.php');
include('frontend-partials/header.php');

// Check if the user is logged in
if (!isset($_SESSION['u_name'])) {
    // $_SESSION['no-login-message'] = "<div class='error'>Please log in to place an order.</div>";
    // header('location:' . HOMEURL . 'login.php');
    exit;
}

// Get the Cake ID from URL
if (isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];

    // Retrieve cake details from the database
    $sql = "SELECT * FROM tbl_cake WHERE c_id = $c_id";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $cake_name = $row['c_name'];
        $cake_price = $row['c_price'];
        $cake_description = $row['c_description'];
        $cake_image = $row['c_image_name'];
    } else {
        $_SESSION['no-cake-found'] = "<div class='error'>Cake not found.</div>";
        header('location:' . HOMEURL . 'index.php');
        exit;
    }
} else {
    header('location:' . HOMEURL . 'index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cake</title>
    <link rel="stylesheet" href="style.css">
<body>

<div class="order-container">
    <!-- Left Section: Cake Details -->
    <div class="order-details">
        <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $cake_image; ?>" alt="Cake Image">
        <h3><?php echo $cake_name; ?></h3><br>
        <h4>Price: Rs.<?php echo $cake_price; ?></h4><br>
        <p><?php echo $cake_description; ?></p>
    </div>

    <!-- Right Section: Order Form -->
    <div class="order-form">
        <form action="" method="POST">
            <table>
                <!-- Quantity -->
                <tr>
                    <td>Quantity:</td>
                    <td><input type="number" name="o_quantity" value="1" min="1" required></td>
                </tr>

                <!-- Delivery Location -->
                <tr>
                    <td>Delivery Location:</td>
                    <td><input type="text" name="o_delivery_location" placeholder="Enter delivery address" required></td>
                </tr>

                <!-- Delivery Date -->
                <tr>
                    <td>Delivery Date:</td>
                    <td><input type="date" name="o_delivery_date" id="delivery-date" required></td>
                </tr>

                <!-- Special Instructions -->
                <tr>
                    <td>Special Instructions:</td>
                    <td><textarea name="o_special_instructions" placeholder="Enter any special instructions (optional)"></textarea></td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="submit" value="Place Order" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('frontend-partials/footer.php'); ?>

    <script>
        // Set today's date as the minimum selectable date for the delivery date input
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        document.getElementById('delivery-date').setAttribute('min', today);
    </script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Get form data
    $o_quantity = $_POST['o_quantity'];
    $o_delivery_location = $_POST['o_delivery_location'];
    $o_delivery_date = $_POST['o_delivery_date'];
    $o_special_instructions = $_POST['o_special_instructions'];

    // Calculate total price
    $total = $cake_price * $o_quantity;

    // Get user ID from session
    $u_id = $_SESSION['u_id']; // Assuming user ID is stored in session

    // Insert order into the database
    $sql2 = "INSERT INTO tbl_order (u_id, c_id, o_quantity, o_delivery_location, o_delivery_date, o_total, o_special_instructions)
             VALUES ('$u_id', '$c_id', '$o_quantity', '$o_delivery_location', '$o_delivery_date', '$total', '$o_special_instructions')";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2 == true) {
        $_SESSION['order'] = "<div class='success'>Order Placed Successfully.</div>";
        header('location:' . HOMEURL . 'myorder.php');
    } else {
        // $_SESSION['order'] = "<div class='error'>Failed to Place Order.</div>";
        header('location:' . HOMEURL . 'index.php');
    }
}
?>