<?php include ('partials/menu.php') ?>
   <!-- main section starts-->
    <div class= "main-content">
        <div class= "wrapper">
        <h1>Manage Category</h1>
        <br><br>
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
                if(isset($_SESSION['no-category-found'])){
                    echo $_SESSION['no-category-found'];
                    unset($_SESSION['no-category-found']);
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
        <br><br>
            <!-- button to add category -->
            <a href="<?php echo HOMEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
            <br><br><br>
            <table class= "tbl-full">
            
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php
                    $sql = "SELECT *FROM tbl_category";

                    $res = mysqli_query($conn,$sql);
                    $count = mysqli_num_rows($res);

                    //sn var
                    $sn =1;
                    if($count>0){
                        //we have data
                        while($row=mysqli_fetch_assoc($res)){
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>
                                <tr>
                                    <td><?php echo $sn++ ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td>
                                        <?php
                                            //checking if image available or not
                                            if($image_name!= ""){
                                                //display image name
                                                echo "<img src='" . HOMEURL . "img/category/" . $image_name . "' width='100px' alt=''>";



                                            }else{
                                                //display no image txt
                                                echo "<div class = 'error'>No Image Found.</div>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td><a href="<?php echo HOMEURL;?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                        <a href="<?php echo HOMEURL;?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }else{
                        //no data
                        ?>
                        <tr>
                            <td colspan = "6"><div class="error">No Category Added.</div></td>
                        </tr>
                        <?php
                    }
                ?>

            </table>
        </div>
     </div>
    <!-- main section ends-->
<?php include('partials/footer.php') ?>