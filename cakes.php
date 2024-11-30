<?php
    include('config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cakes - Cake Ordering System</title>
    <link rel="stylesheet" href = "style.css">
    <?php include 'frontend-partials/header.php'; ?>
    
</head>
<body>


    <main>
        <section>
            <h2>Our Cakes</h2>
            <div class="cake-grid">
                <?php
                    //cake that are active to be displayed 
                    $sql = "SELECT *FROM tbl_cake where active = 'Yes'";
                    $res = mysqli_query($conn,$sql);
                    $count = mysqli_num_rows($res);
                    if($count >0){
                        while($row = mysqli_fetch_assoc($res)){
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
                        echo "<div class = 'error'>No Cakes Available.</div>";
                    }
                    
                ?>
            </div>
        </section>
    </main>

    <?php include 'frontend-partials/footer.php'; ?>

</body>
</html>
