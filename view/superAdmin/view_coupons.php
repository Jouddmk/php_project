<?php
// Include your database connection
include('db.php');

// Start session
session_start();

// Check if admin is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .nav-link {
            color: white;
        }
        .nav-link:hover {
            color: #ffcc00;
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #wrapper {
            display: flex;
            height: 100%;
        }
        #sidebar-wrapper {
            width: 250px;
            flex-shrink: 0;
            height: 100%;
            overflow-y: auto;
            background-color: #343a40;
        }
        #sidebar-wrapper .sidebar-heading {
            padding: 20px;
            font-size: 1.2rem;
            color: white;
            text-align: center;
        }
        .list-group-item {
            border: none;
            padding: 15px 20px;
            color: white;
            background-color: #343a40;
        }
        .list-group-item:hover {
            background-color: #495057;
            color: #ffcc00;
        }
        #page-content-wrapper {
            flex-grow: 1;
            overflow-y: auto;
            background-color: #f8f9fa;
        }
        .navbar {
            padding: 15px;
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 0;
        }
        .table th, .table td {
            padding: 12px;
            vertical-align: middle;
        }
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
        .modal-content {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            background-color: #343a40;
            color: white;
            border-bottom: none;
        }
        .modal-header .close {
            color: white;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="d-flex" id="wrapper">
    <div class="bg-dark border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-white"> Super Admin Dashboard</div>
        <div class="list-group list-group-flush">
            <a href="index.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-home"></i> Dashboard</a>
            <a href="product.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-box"></i> Products</a>
            <a href="users.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-users"></i> Users</a>
            <a href="view_orders.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-shopping-cart"></i> Orders</a>
            <a href="view_coupons.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-tags"></i> Coupons</a>
            <a href="view_categories.php" class="list-group-item list-group-item-action bg-dark nav-link"><i class="fas fa-list"></i> Categories</a>
            <a href="../home.php" class="list-group-item list-group-item-action"><i class="fa-solid fa-bag-shopping"></i> Go shoping</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <h2>Welcome to the Super Admin Dashboard</h2>
        </nav>

        <div class="container-fluid mt-4">
            <div class="row">
                <!-- Add Coupon Button -->
                <div class="col-lg-12 mb-3">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addCouponModal">
                        <i class="fas fa-plus"></i> Add Coupon
                    </button>
                </div>

                <!-- Coupons Table -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Coupons</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Expiration Date</th>
                                        <th>Usage Limit</th>
                                        <th>Date Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch coupons data from the database
                                    $get_coupons = "SELECT * FROM coupons";
                                    $run_coupons = mysqli_query($con, $get_coupons);

                                    while ($row = mysqli_fetch_array($run_coupons)) {
                                        $id = $row['id'];
                                        $code = $row['code'];
                                        $discount = $row['discount'];
                                        $expiration_date = $row['expiration_date'];
                                        $usage_limit = $row['usage_limit'];
                                        $created_at = $row['created_at'];
                                        echo "
                                            <tr>
                                                <td>$id</td>
                                                <td>$code</td>
                                                <td>$discount%</td>
                                                <td>$expiration_date</td>
                                                <td>$usage_limit</td>
                                                <td>$created_at</td>
                                                <td>
                                                    <button class='btn btn-warning btn-sm edit-coupon' data-id='$id' data-code='$code' data-discount='$discount' data-expiration-date='$expiration_date' data-usage-limit='$usage_limit'>Edit</button>
                                                   <a href='delete.php?id=$id&table=coupons' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this coupon?\");'>Delete</a>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCouponModalLabel">Add Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCouponForm" action="add_coupon.php" method="POST">
                    <div class="form-group">
                        <label for="addCouponCode">Coupon Code</label>
                        <input type="text" class="form-control" id="addCouponCode" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="addCouponDiscount">Discount (%)</label>
                        <input type="number" class="form-control" id="addCouponDiscount" name="discount" required>
                    </div>
                    <div class="form-group">
                        <label for="addCouponExpirationDate">Expiration Date</label>
                        <input type="date" class="form-control" id="addCouponExpirationDate" name="expiration_date" required>
                    </div>
                    <div class="form-group">
                        <label for="addCouponUsageLimit">Usage Limit</label>
                        <input type="number" class="form-control" id="addCouponUsageLimit" name="usage_limit" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Coupon</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCouponModalLabel">Edit Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCouponForm" action="update_coupon.php" method="POST">
                    <input type="hidden" id="editCouponId" name="id">
                    <div class="form-group">
                        <label for="editCouponCode">Coupon Code</label>
                        <input type="text" class="form-control" id="editCouponCode" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="editCouponDiscount">Discount (%)</label>
                        <input type="number" class="form-control" id="editCouponDiscount" name="discount" required>
                    </div>
                    <div class="form-group">
                        <label for="editCouponExpirationDate">Expiration Date</label>
                        <input type="date" class="form-control" id="editCouponExpirationDate" name="expiration_date" required>
                    </div>
                    <div class="form-group">
                        <label for="editCouponUsageLimit">Usage Limit</label>
                        <input type="number" class="form-control" id="editCouponUsageLimit" name="usage_limit" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Show edit coupon modal
    $('.edit-coupon').on('click', function() {
        var couponId = $(this).data('id');
        var couponCode = $(this).data('code');
        var couponDiscount = $(this).data('discount');
        var couponExpirationDate = $(this).data('expiration-date');
        var couponUsageLimit = $(this).data('usage-limit');

        $('#editCouponId').val(couponId);
        $('#editCouponCode').val(couponCode);
        $('#editCouponDiscount').val(couponDiscount);
        $('#editCouponExpirationDate').val(couponExpirationDate);
        $('#editCouponUsageLimit').val(couponUsageLimit);
        $('#editCouponModal').modal('show');
    });
});
</script>

</body>
</html>