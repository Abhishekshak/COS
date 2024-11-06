
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
            $path = "../img/category/".$image_name;
            //remove
            $remove = unlink($path);
            //if failed to remove image then add an error txt
            if($remove == FALSE){
                //set the session txt 
                $_SESSION['remove'] = "<div class = 'error'>Failed to remove Category Image</div>";
                header('location:'.HOMEURL.'admin/manage-category.php');
                die();
            }
        }
            $sql = "DELETE FROM tbl_category WHERE id=$id";

            $res = mysqli_query($conn,$sql);

            if($res == TRUE){
                $_SESSION['delete'] = "<div class = 'success'>Category deleted sucessfully.</div";
                header('location:'.HOMEURL.'admin/manage-category.php');
            }else{
                $_SESSION['delete'] = "<div class = 'error'>Failed to delete category.</div";
                header('location:'.HOMEURL.'admin/manage-category.php');
            }
    }else{
        // redirect to manage category
        header('location:'.HOMEURL.'admin/manage-category.php');
    }
?>