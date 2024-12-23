<?php
    include('config/constants.php');
    // Check if the user is logged in
    $is_logged_in = isset($_SESSION['u_name']); // True if logged in, false otherwise
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cakes - Cake Ordering System</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'frontend-partials/header.php'; ?>
</head>
<body>

    <main>
    <section>
            <h1>Order your favorite cakes with ease and have them delivered to your doorstep.</h1>
            <div class="search">
                <form action="search.php" method= "GET">
                    <input type="text" class="search-bar" placeholder="Browse for cakes" name = "query">
                    <button class="search-button" type= "submit">Search</button>
                </form>
            </div>
    </section>
        <section>
            <h2>OUR CAKES</h2>
            <div class="cake-grid">
                <?php
                    // Fetch cakes that are active to be displayed
                    $sql = "SELECT * FROM tbl_cake WHERE c_active = 'Yes'";
                    $res = mysqli_query($conn, $sql);
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            // Fetch cake details
                            $id = $row['c_id'];  // Updated column name
                            $title = $row['c_name'];  // Updated column name
                            $description = $row['c_description'];  // Updated column name
                            $price = $row['c_price'];  // Updated column name
                            $image_name = $row['c_image_name'];  // Updated column name
                ?>
                            <div class="cake-item">
                                <?php
                                    // Handle missing image
                                    if ($image_name == "") {
                                        echo "<div class='error'>Image Not Available</div>";
                                    } else {
                                ?>
                                        <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $image_name; ?>" alt="Cake Image">
                                <?php
                                    }
                                ?>

                                <h3><?php echo htmlspecialchars($title); ?></h3>
                                <h5><?php echo htmlspecialchars($description); ?></h5>
                                <h4>Price: Rs.<?php echo htmlspecialchars($price); ?></h4>
                                
                                <!-- Order Now Button -->
                                <button onclick="window.location.href='<?php echo $is_logged_in ? 'order.php?c_id=' . $id : 'login.php'; ?>'">
                                    Order Now
                                </button>

                            </div>
                <?php
                        }
                    } else {
                        echo "<div class='error'>No Cakes Available.</div>";
                    }
                ?>
            </div>
        </section>
    </main>

    <?php include 'frontend-partials/footer.php'; ?>

</body>
</html>
