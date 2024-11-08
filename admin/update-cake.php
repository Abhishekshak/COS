<?php
    include("partials/menu.php");
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Cake</h1>
            <br>
            <br>
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $sql = "SELECT *FROM tbl_cake WHERE id = $id";
                    $res = mysqli_query($conn,$sql);
                    
                    $count = mysqli_num_rows($res);
                    if($count ==1){
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                    }else{
                        $_SESSION['no-cake-found'] = "<div class = 'error'>Cake not found.</div>";
                        header("location:".HOMEURL.'admin/manage-cake.php');
                    }
                }else{
                    header('location:'.HOMEURL.'admin/cake-category.php');
                }
            ?>
            <form action="" method = "POST" enctype = "multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value= "<?php echo $title; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value= "<?php echo $price; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php
                                if($current_image != ""){
                            ?>
                                    <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $current_image; ?>" alt="" width = "170px">
                            <?php
                                }else{
                                    echo "<div class = 'error'>Image not Added.</div>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image: </td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td><input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name= "featured" value = "Yes">Yes
                        <input <?php if($featured == "No"){echo "unchecked";} ?> type="radio" name= "featured" value = "No">No
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td><input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name= "active" value = "Yes">Yes
                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name= "active" value = "No">No
                        </td>
                    </tr>
                    <tr>
                        <input type="hidden" name = "current_image" value = "<?php echo $current_image ?>">
                        <input type="hidden" name = "id" value = "<?php echo $id ?>">
                        <td><input type="submit" name = "submit" value = "Update Cake" class = "btn-secondary"></td>
                    </tr>
                </table>
            </form>

            <?php
                 //getting value from form 
                 if(isset($_POST['submit'])){
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];
                //updating new image
                //checking if image selected or not
                if(isset($_FILES['image']['name'])){
                    $image_name = $_FILES['image']['name'];
                    if($image_name != ""){
                        //image available
                        //upload new img 
                        //auto rename image
                         $ext = end(explode('.',$image_name));

                        //rename
                        $image_name = "Cake_Name_".rand(000,999).'.'.$ext;
                        
                        
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../img/cake/".$image_name;
                                                    
                        $upload = move_uploaded_file($source_path,$destination_path);
                        
                        //check if image uploaded or not 
                        if($upload == FALSE){
                            $_SESSION['upload'] = "<div class = 'error'>Failed to Upload Image.</div>";
                            header('location:'.HOMEURL.'admin/manage-cake.php');
                            die();
                        }

                        //and remove current if available
                        if($current_image != ""){
                            $remove_path = "../img/cake/".$current_image;
                            $remove = unlink($remove_path);
                            if($remove == FALSE){
                                $_SESSION['failed-remove'] = "<div class = 'error'>Failed to remove current image.</div>";
                                header('location'.HOMEURL.'admin/manage-cake');
                                die();
                            }
                        }

                    }else{
                        $image_name = $current_image;
                    }
                }else{
                    $image_name = $current_image;
                }

                //updating the db 
                $sql2 = "UPDATE tbl_cake SET 
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id = $id";
                $res2 = mysqli_query($conn,$sql2);
                //redirect after success
                if($res2 == true){
                    $_SESSION['update'] = "<div class = 'success'>Cake details updated sucessfully.</div>";
                    header('location:'.HOMEURL.'admin/manage-cake.php');
                }else{
                    // echo "Failed to Update Category";
                    $_SESSION['update'] = "<div class = 'error'>Failed to update cake details.</div>";
                    header('location:'.HOMEURL.'admin/manage-cake.php');
                }
                 }

            ?>
        </div>
    </div>
<?php
    include("partials/footer.php");
?>