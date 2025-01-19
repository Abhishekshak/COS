<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br>
        <?php if (isset($_SESSION['update'])) { ?>
            <div class="alert">
                <?php 
                    echo $_SESSION['update']; 
                    unset($_SESSION['update']); 
                ?>
            </div>
        <?php } ?>

        <div class="controls">
            <input type="text" id="searchInput" placeholder="Search orders...">
            <select id="statusFilter">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <table class="tbl-full">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Cake</th>
                <th>Delivery Info</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
     $sql = "SELECT o.*, u.u_name, u.u_email, u.u_contact, c.c_name 
     FROM tbl_order o 
     JOIN tbl_users u ON o.u_id = u.u_id 
     JOIN tbl_cake c ON o.c_id = c.c_id 
     ORDER BY o.o_id DESC";

                    
            
            $res = mysqli_query($conn, $sql);
            
            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $o_id = $row['o_id'];
            ?>
                        <tr class="order-row">
                            <td>#<?php echo $o_id; ?></td>
                            <td>
                                <strong><?php echo $row['u_name']; ?></strong><br>
                                <small><?php echo $row['u_contact']; ?></small>
                            </td>
                            <td>
                                <?php echo $row['c_name']; ?><br>
                                <small>Qty: <?php echo $row['o_quantity']; ?></small>
                            </td>
                            <td>
                                <?php echo $row['o_delivery_location']; ?><br>
                                <small><?php echo date('d M Y', strtotime($row['o_delivery_date'])); ?></small>
                            </td>
                            <td>Rs. <?php echo number_format($row['o_total']); ?></td>
                            <td>
                                <span class="badge <?php echo strtolower($row['o_status']); ?>">
                                    <?php echo ucfirst($row['o_status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="update-order.php?o_id=<?php echo $o_id; ?>" class="btn-secondary">Update</a>
                                <button onclick="toggleDetails('<?php echo $o_id; ?>')" class="btn-secondary">Details</button>
                            </td>
                        </tr>
                        <tr id="details-<?php echo $o_id; ?>" class="order-details">
                            <td colspan="7">
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <label>Customer Email:</label>
                                        <?php echo $row['u_email']; ?>
                                    </div>
                                    <div class="detail-item">
                                        <label>Special Instructions:</label>
                                        <?php echo $row['o_special_instructions'] ?? 'None'; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>No Orders Found</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', filterOrders);
document.getElementById('statusFilter').addEventListener('change', filterOrders);

function filterOrders() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();
    const rows = document.getElementsByClassName('order-row');

    for (let row of rows) {
        const text = row.textContent.toLowerCase();
        const statusBadge = row.querySelector('.badge').textContent.toLowerCase();
        
        const matchesSearch = text.includes(search);
        const matchesStatus = status === '' || statusBadge.includes(status);
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
        
        const detailsRow = row.nextElementSibling;
        if (detailsRow && detailsRow.classList.contains('order-details')) {
            detailsRow.style.display = 'none';
        }
    }
}

function toggleDetails(orderId) {
    const detailsRow = document.getElementById('details-' + orderId);
    detailsRow.classList.toggle('show');
}
</script>

<?php include('partials/footer.php'); ?>