<?php include ('partials/menu.php') ?>
   <!-- main section starts-->
    <div class= "main-content">
        <div class= "wrapper">
            <h1>Manage Admin</h1>
            <br><br>

            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                } 
            ?>
            <?php
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                } 
            ?>
            <?php
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                } 
            ?>
            
            <br>
            <br>
            <!-- button to add admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>
            <table class= "tbl-full">
            
                <tr>
                    <th>S.N</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    $sql = "SELECT *FROM tbl_admin";
                    $res = mysqli_query($conn,$sql);
                    if($res ==TRUE){
                        //counting rows 
                        $count = mysqli_num_rows($res);
                        $sn =1;
                        if($count>0){
                            //we got data in db
                            while($rows=mysqli_fetch_assoc($res)){
                                $id=$rows['id'];
                                $username = $rows['username'];
                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><a href="<?php echo HOMEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo HOMEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }else{
                            //we got no data in db
                        }
                    }


                ?>
                </tr>
            </table>

        </div>
     </div>
    <!-- main section ends-->
<?php include('partials/footer.php') ?>