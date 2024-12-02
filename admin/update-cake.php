<?php
    include("partials/menu.php");
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Cake</h1>
            <br>
            <br>
            <?php
                if(isset($_GET['c_id'])){
                    $c_id = $_GET['c_id'];
                    $sql = "SELECT * FROM tbl_cake WHERE c_id = $c_id";  // Use c_id as the primary key
                    $res = mysqli_query($conn, $sql);
                    
                    $count = mysqli_num_rows($res);
                    if($count == 1){
                        $row = mysqli_fetch_assoc($res);
                        $c_name = $row['c_name'];
                        $c_description = $row['c_description'];
                        $c_price = $row['c_price'];
                        $c_current_image = $row['c_image_name'];  // Updated column name
                        $c_featured = $row['c_featured'];
                        $c_active = $row['c_active'];
                    } else {
                        $_SESSION['no-cake-found'] = "<div class = 'error'>Cake not found.</div>";
                        header("location:".HOMEURL.'admin/manage-cake.php');
                    }
                } else {
                    header('location:'.HOMEURL.'admin/manage-cake.php');
                }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Name: </td>
                        <td>
                            <input type="text" name="c_name" value="<?php echo $c_name; ?>">  <!-- Updated to $c_name -->
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="c_description" cols="30" rows="5"><?php echo isset($c_description) ? $c_description : ''; ?></textarea>  <!-- Updated to $c_description -->
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="c_price" value="<?php echo $c_price; ?>">  <!-- Updated to $c_price -->
                        </td>
                    </tr>
                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php
                                if($c_current_image != ""){
                            ?>
                                    <img src="<?php echo HOMEURL; ?>img/cake/<?php echo $c_current_image; ?>" alt="" width="170px">  <!-- Updated to $c_current_image -->
                            <?php
                                } else {
                                    echo "<div class = 'error'>Image not Added.</div>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image: </td>
                        <td><input type="file" name="c_image_name"></td> <!-- Updated to c_image_name -->
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($c_featured == "Yes"){echo "checked";} ?> type="radio" name="c_featured" value="Yes">Yes
                            <input <?php if($c_featured == "No"){echo "checked";} ?> type="radio" name="c_featured" value="No">No  <!-- Updated to $c_featured -->
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($c_active == "Yes"){echo "checked";} ?> type="radio" name="c_active" value="Yes">Yes
                            <input <?php if($c_active == "No"){echo "checked";} ?> type="radio" name="c_active" value="No">No  <!-- Updated to $c_active -->
                        </td>
                    </tr>
                    <tr>
                        <input type="hidden" name="current_image" value="<?php echo $c_current_image; ?>">  <!-- Keeping the current image name -->
                        <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">  <!-- Use c_id -->
                        <td><input type="submit" name="submit" value="Update Cake" class="btn-secondary"></td>
                    </tr>
                </table>
            </form>

            <?php
                 // Handling form submission
                 if(isset($_POST['submit'])){
                    $c_id = $_POST['c_id'];
                    $c_name = $_POST['c_name'];
                    $c_description = $_POST['c_description'];
                    $c_price = $_POST['c_price'];
                    $current_image = $_POST['current_image'];
                    $c_featured = $_POST['c_featured'];
                    $c_active = $_POST['c_active'];

                    // Handling new image upload
                    if(isset($_FILES['c_image_name']['name'])){
                        $image_name = $_FILES['c_image_name']['name'];
                        if($image_name != ""){
                            // Image available, rename it
                            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                            $image_name = "Cake_Name_" . rand(000, 999) . '.' . $ext;

                            $source_path = $_FILES['c_image_name']['tmp_name'];
                            $destination_path = "../img/cake/" . $image_name;

                            $upload = move_uploaded_file($source_path, $destination_path);

                            if($upload == FALSE){
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                header('location:' . HOMEURL . 'admin/manage-cake.php');
                                die();
                            }

                            // Remove current image if exists
                            if($current_image != ""){
                                $remove_path = "../img/cake/" . $current_image;
                                $remove = unlink($remove_path);
                                if($remove == FALSE){
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                                    header('location:' . HOMEURL . 'admin/manage-cake.php');
                                    die();
                                }
                            }
                        } else {
                            $image_name = $current_image;
                        }
                    } else {
                        $image_name = $current_image;
                    }

                    // Update the cake details in the database
                    $sql2 = "UPDATE tbl_cake SET 
                        c_name = '$c_name',
                        c_description = '$c_description',
                        c_price = '$c_price',
                        c_image_name = '$image_name',
                        c_featured = '$c_featured',
                        c_active = '$c_active' 
                        WHERE c_id = $c_id";  // Use c_id as the primary key

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2 == TRUE){
                        $_SESSION['update'] = "<div class='success'>Cake details updated successfully.</div>";
                        header('location:' . HOMEURL . 'admin/manage-cake.php');
                    } else {
                        $_SESSION['update'] = "<div class='error'>Failed to update cake details.</div>";
                        header('location:' . HOMEURL . 'admin/manage-cake.php');
                    }
                 }
            ?>
        </div>
    </div>
<?php
    include("partials/footer.php");
?>
     