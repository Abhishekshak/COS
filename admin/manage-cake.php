<?php include ('partials/menu.php') ?>
   <!-- main section starts-->
    <div class= "main-content">
        <div class= "wrapper">
        <h1>Manage Cake</h1>
        <br><br>
            <!-- button to add food -->
            <a href="<?php echo HOMEURL; ?>admin/add-cake.php" class="btn-primary">Add Cake</a>
            <br><br><br>
            
            <?php
                    if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                    }
                    if(isset($_SESSION['remove'])){
                        echo $_SESSION['remove'];
                        unset($_SESSION['remove']);
                    }
                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['no-cake-found'])){
                        echo $_SESSION['no-cake-found'];
                        unset($_SESSION['no-cake-found']);
                    }
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    if(isset($_SESSION['upload'])){
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                    if(isset($_SESSION['failed-remove'])){
                        echo $_SESSION['failed-remove'];
                        unset($_SESSION['failed-remove']);
                    }
            ?>
            <br>
            <table class= "tbl-full">
            
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php
                //creating sql to retrieve all the food details
                $sql = "SELECT *FROM tbl_cake";
                $res = mysqli_query($conn,$sql); 
                $count = mysqli_num_rows($res);

                $sn =1;
                if($count>0){
                    //we got cakes
                    while($row=mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>$<?php echo $price; ?></td>
                            <td><?php
                                    if($image_name == ""){
                                        echo "<div class = 'error'>No Image Found</div>";
                                    }else{
                                        ?>
                                        <img src="<?php echo HOMEURL; ?>/img/cake/<?php echo $image_name; ?>" width = "100px">
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td><a href="<?php echo HOMEURL;?>admin/update-cake.php?id=<?php echo $id; ?>" class="btn-secondary">Update Cake</a>
                                <a href="<?php echo HOMEURL;?>admin/delete-cake.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Cake</a>
                            </td>
                        </tr>
                        <?php
                    }

                }else{
                    //zero cakes in db
                    echo "<tr><td class = 'error'>Cakes not added.<td></tr>";
                }
                ?>

            </table>
        </div>
     </div>
    <!-- main section ends-->
<?php include('partials/footer.php') ?>