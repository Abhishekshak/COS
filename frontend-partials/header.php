<!-- header.php -->
 <?php include('config/constants.php'); ?>
<header>
    <div class="header-container">
        <img src="img/logo.png" alt="Cake Ordering System Logo" class="logo"> <!-- Logo on the left -->
        <nav>
            <a href="<?php echo HOMEURL;?>">Home</a>
            <a href="<?php echo HOMEURL; ?>cakes.php">Cakes</a>
            <!-- <a href="cart.php">Cart</a> -->
            <a href="<?php echo HOMEURL; ?>checkout.php">Checkout</a>
        </nav>

    </div>
    <!-- <div class="sign-in-up">
                <button type="button">LOGIN</button>
                <button type="button">REGISTER</button>
        </div> -->
</header>
