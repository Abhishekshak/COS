<?php include ('partials/menu.php') ?>
   <!-- main section starts-->
    <div class= "main-content">
        <div class= "wrapper">
        <h1>Manage Cake</h1>
        <br><br>
            <!-- button to add food -->
            <a href="<?php echo HOMEURL; ?>admin/add-cake.php" class="btn-primary">Add Cake</a>
            <br><br><br>
            <table class= "tbl-full">
            
                <tr>
                    <th>S.N</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Abhishek</td>
                    <td><a href="#" class="btn-secondary">Update Admin</a>
                        <a href="#" class="btn-danger">Delete Admin</a>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Shakya</td>
                    <td><a href="#" class="btn-secondary">Update Admin</a>
                        <a href="#" class="btn-danger">Delete Admin</a>
                    </td>
                </tr>
            </table>
        </div>
     </div>
    <!-- main section ends-->
<?php include('partials/footer.php') ?>