
<?php
    include('../config/constants.php');
    // echo "test";
    //checking if img and id val is set

    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        //delete
        // echo "delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //removes img from local storage if available and then del from db 
        if($image_name != ""){
            //img path
            $path = "../img/cake/".$image_name;
            //remove
            $remove = unlink($path);
            //if failed to remove image then add an error txt
            if($remove == FALSE){
                //set the session txt 
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove Cake Image</div>";
                header('location:'.HOMEURL.'admin/manage-cake.php');
                die();
            }
        }
            $sql = "DELETE FROM tbl_cake WHERE id=$id";

            $res = mysqli_query($conn,$sql);

            if($res == TRUE){
                $_SESSION['delete'] = "<div class = 'success'>Cake removed sucessfully.</div";
                header('location:'.HOMEURL.'admin/manage-cake.php');
            }else{
                $_SESSION['delete'] = "<div class = 'error'>Failed to remove cake.</div";
                header('location:'.HOMEURL.'admin/manage-cake.php');
            }
    }else{
        // redirect to manage cake
        header('location:'.HOMEURL.'admin/manage-cake.php');
    }
?>