<?php
   

    // Check if the user is logged in (i.e., session variable 'u_name' is set)
    $is_logged_in = isset($_SESSION['u_name']);
    $user_name = $is_logged_in ? $_SESSION['u_name'] : '';
?>

<header>
    <div class="header-container">
        <!-- Logo on the left -->
        <img src="img/logo.png" alt="Cake Ordering System Logo" class="logo"><p class = "nav-head">COS</p>

        <nav>
            <a href="<?php echo HOMEURL;?>">Home</a>
            <a href="<?php echo HOMEURL; ?>cakes.php">Cakes</a>

            <?php if ($is_logged_in): ?>
                <!-- If logged in, show Welcome message and Logout button -->
                <a href="profile.php">Welcome, <?php echo htmlspecialchars($user_name); ?>!</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <!-- If not logged in, show Login and Register buttons -->
                <a href="login.php" id="login">Login</a>
                <a href="register.php" id="register">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>