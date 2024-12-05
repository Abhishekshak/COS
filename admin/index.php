
<?php include ('partials/menu.php');


// Fetch number of users
$query_users = "SELECT COUNT(*) AS total_users FROM tbl_users";
$result_users = mysqli_query($conn, $query_users);
$data_users = mysqli_fetch_assoc($result_users);
$total_users = $data_users['total_users'];

// Fetch number of cakes
$query_cakes = "SELECT COUNT(*) AS total_cakes FROM tbl_cake";
$result_cakes = mysqli_query($conn, $query_cakes);
$data_cakes = mysqli_fetch_assoc($result_cakes);
$total_cakes = $data_cakes['total_cakes'];

// Fetch number of orders
$query_orders = "SELECT COUNT(*) AS total_orders FROM tbl_order";
$result_orders = mysqli_query($conn, $query_orders);
$data_orders = mysqli_fetch_assoc($result_orders);
$total_orders = $data_orders['total_orders'];

// Fetch total income (assuming you store price in the orders table)
$query_income = "SELECT SUM(o_total) AS total_income FROM tbl_order"; // Assuming 'price' column stores the order price
$result_income = mysqli_query($conn, $query_income);
$data_income = mysqli_fetch_assoc($result_income);
$total_income = $data_income['total_income'];

?>



<!-- main section starts-->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>
        <br>
        <?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br>
        <div class="col-4 text-center">
            <h1><?php echo $total_users; ?></h1>
            <br>
            Users
        </div>
        <div class="col-4 text-center">
            <h1><?php echo $total_cakes; ?></h1>
            <br>
            Cakes
        </div>
        <div class="col-4 text-center">
            <h1><?php echo $total_orders; ?></h1>
            <br>
            Orders
        </div>
        <div class="col-4 text-center">
            <h1>$<?php echo number_format($total_income, 2); ?></h1>
            <br>
            Income
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<!-- main section ends-->

<?php include('partials/footer.php'); ?>
