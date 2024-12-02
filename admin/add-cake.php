<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Cake</h1>
        <br><br>
        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['empty'])) {
            echo $_SESSION['empty'];
            unset($_SESSION['empty']);
        }
        ?>
        <br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Name: </td>
                    <td><input type="text" name="c_name" placeholder="Name of the Cake"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td><textarea name="c_description" placeholder="Description of the Cake" cols="25" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="c_price" placeholder="Cake Price"></td>
                </tr>
                <tr>
                    <td>Image: </td>
                    <td><input type="file" name="c_image"></td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="c_featured" value="Yes">Yes
                        <input type="radio" name="c_featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="c_active" value="Yes">Yes
                        <input type="radio" name="c_active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Cake" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // 1. Get form data
            $c_name = $_POST['c_name'];
            $c_description = $_POST['c_description'];
            $c_price = $_POST['c_price'];

            $c_featured = isset($_POST['c_featured']) ? $_POST['c_featured'] : 'No';
            $c_active = isset($_POST['c_active']) ? $_POST['c_active'] : 'No';

            // Validate form fields
            if (empty($c_name) || empty($c_description) || empty($c_price)) {
                $_SESSION['empty'] = "<div class='error'>Please fill in all required fields!</div>";
            } else {
                // 2. Handle image upload
                if (isset($_FILES['c_image']['name'])) {
                    $c_image_name = $_FILES['c_image']['name'];
                    if ($c_image_name != "") {
                        // Auto rename image
                        $ext = end(explode('.', $c_image_name));
                        $c_image_name = "Cake_Name_" . rand(000, 999) . '.' . $ext;

                        $source_path = $_FILES['c_image']['tmp_name'];
                        $destination_path = "../img/cake/" . $c_image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        if ($upload == false) {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:' . HOMEURL . 'admin/add-cake.php');
                            die();
                        }
                    }
                } else {
                    $c_image_name = "";
                }

                // 3. Insert into database
                $sql2 = "INSERT INTO tbl_cake SET
                    c_name = '$c_name',
                    c_description = '$c_description',
                    c_price = $c_price,
                    c_image_name = '$c_image_name',
                    c_featured = '$c_featured',
                    c_active = '$c_active'";

                $res2 = mysqli_query($conn, $sql2);

                // 4. Redirect to Manage Cake with session message
                if ($res2 == true) {
                    $_SESSION['add'] = "<div class='success'>Cake Added Successfully.</div>";
                    header('location:' . HOMEURL . 'admin/manage-cake.php');
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Cake.</div>";
                    header('location:' . HOMEURL . 'admin/manage-cake.php');
                }
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
