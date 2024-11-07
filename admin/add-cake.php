<?php include('partials/menu.php') ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Cake</h1>
            <br>
            <br>
            <?php
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['empty'])){
                echo $_SESSION['empty'];
                unset($_SESSION['empty']);
            }
            ?>
            <br>
            <form action="" method = "POST" enctype = "multipart/form-data">

            <table class = "tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name= "title" placeholder = "Name of the Cake"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" placeholder= "Description of the Cake" cols = "25" rows= "5"></textarea></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" name= "price" placeholder = "Cake Price"></td>
                </tr>
                <tr>
                    <td>Image: </td>
                    <td><input type="file" name= "image"></td>
                </tr>
                <!-- <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <option value="1">Pound</option>
                            <option value="2">Sponge</option>
                        </select>
                    </td>

                </tr> -->
                <tr>
                    <td>Featured: </td>
                    <td><input type="radio" name = "featured" value = "Yes">Yes
                        <input type="radio" name = "featured" value = "No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td><input type="radio" name = "active" value = "Yes">Yes
                        <input type="radio" name = "active" value = "No">No
                    </td>
                </tr>
                <tr colspan= "2">
                    <td><input type="submit" name = "submit" value= "Add Cake" class = "btn-secondary"></td>
                </tr>

            </table>
            </form>

            
            <?php
                //checking if btn is working
                if(isset($_POST['submit'])){
                    // echo "workk";
                    //1. getting data from form 
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];

                    if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                    }else{
                        $featured = "No";
                    }
                    if(isset($_POST['active'])){
                        $active = $_POST['active'];
                        }else{
                            $active = "No";
                        }

                    //validatingggg
                    if (empty($title) || empty($description) || empty($price)) {
                        $_SESSION['empty'] = "<div class='error'>Please fill in all required fields!</div>";
                    }else{
                            //2. getting image
                            if(isset($_FILES['image']['name'])){
                                $image_name = $_FILES['image']['name'];
                                if($image_name != ""){
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
                                        header('location:'.HOMEURL.'admin/add-food.php');
                                        die();
                                    }
                                }    
                            }else{
                                $image_name = "";
                            }

                            //3. upload in db
                                    $sql2 = "INSERT INTO tbl_cake SET
                                    title = '$title', 
                                    description = '$description',
                                    price = $price,
                                    image_name = '$image_name',
                                    featured = '$featured',
                                    active= '$active'";

                                $res2 = mysqli_query($conn,$sql2);
                            //4. redirect to manage cake with session msg
                                if($res2 ==TRUE){
                                    //cake added
                                    $_SESSION['add'] = "<div class = 'success'>Cake Added Sucessfully.</div>";
                                    header('location:'.HOMEURL.'admin/manage-cake.php');
                                }else{
                                    //cake not added
                                    $_SESSION['add'] = "<div class = 'error'>Failed to add Cake.</div>";
                                    header('location:'.HOMEURL.'admin/manage-cake.php');
                                }
                    }
                }
            ?>
            
        </div>
    </div>
<?php include('partials/footer.php') ?>