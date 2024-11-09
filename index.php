<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Cake Ordering System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include 'frontend-partials/header.php'; ?>

    <main>
        <section>
            <h1>Order your favorite cakes with ease and have them delivered to your doorstep.</h1>
            <div class="search">
                <input type="text" class="search-bar" placeholder="Browse for cakes">
                <button class="search-button">Search</button>
            </div>

            
        </section>
        <section>
            <h1>FEATURED PRODUCTS</h1>

            <div class="cake-grid">
                <?php
                    //cake that are active and featured to be displayed in homescreen 
                    $sql = "SELECT *FROM tbl_cake WHERE active = 'Yes' AND featured = 'Yes' LIMIT 6";
                    $res = mysqli_query($conn,$sql);
                    $count = mysqli_num_rows($res);
                    if($count >0){
                        while($row =mysqli_fetch_assoc($res)){
                            //getting all the values
                            $id = $row['id'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            ?>
                                <div class="cake-item">
                                    <?php
                                        if($image_name == ""){
                                            //image not available
                                            echo "<div class = 'error'>Image Not Available</div>";
                                        }else{
                                            ?>
                                                <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $image_name; ?>" alt="Vanilla Cake">
                                            <?php
                                        }
                                    ?>
                                    
                                    <h3><?php echo $title; ?></h3>
                                    <h5><?php echo $description; ?></h5>
                                    <h4>Price: $<?php echo $price; ?></h4>
                                    <button>Add to Cart</button>
                                </div>
                            <?php
                        }
                    }else{
                        echo "<div class = 'error'>No Cakes available</div>";
                    }

                ?>

            </div>
        </section>
    </main>

    <?php include 'frontend-partials/footer.php'; ?>

</body>
</html>
