<?php
// Include your database connection
include('db.php');

// Start session
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Super Admin Dashboard - Orders</title>
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
        <div class="sidebar-heading text-white"> Super Admin Dashboard </div>
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
                <!-- Orders Table -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Orders</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Name</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch orders data along with the customer name
                                    $get_orders = "
                                        SELECT orders.id, users.name AS customer_name, orders.total_price, orders.status, orders.created_at
                                        FROM orders
                                        JOIN users ON orders.user_id = users.id
                                    ";

                                    $run_orders = mysqli_query($con, $get_orders);

                                    // Display each order with the customer name
                                    while ($row = mysqli_fetch_array($run_orders)) {
                                        $id = $row['id'];
                                        $customer_name = $row['customer_name'];
                                        $total_price = $row['total_price'];
                                        $status = $row['status'];
                                        $created_at = $row['created_at'];
                                        echo "
                                            <tr>
                                                <td>$id</td>
                                                <td>$customer_name</td>
                                                <td>$total_price</td>
                                                <td>$status</td>
                                                <td>$created_at</td>
                                                <td>
                                                    <button class='btn btn-warning btn-sm edit-order' data-id='$id' data-status='$status'>Edit</button>
                                                    <button class='btn btn-info btn-sm show-details' data-id='$id'>Show</button>
                                                    <a href='delete.php?id=$id&table=users' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
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

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm" action="update_order.php" method="POST">
                    <input type="hidden" id="editOrderId" name="id">
                    <div class="form-group">
                        <label for="editOrderStatus">Status</label>
                        <select class="form-control" id="editOrderStatus" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailsBody">
                        <!-- Order details will be populated here via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Show order details in a modal
    $('.show-details').on('click', function() {
        var orderId = $(this).data('id');
        
        $.ajax({
            url: 'get_order_details.php',
            type: 'GET',
            data: { order_id: orderId },
            success: function(response) {
                $('#orderDetailsBody').html(response);
                $('#orderDetailsModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
                $('#orderDetailsBody').html("<tr><td colspan='5'>Error loading order details. Please try again.</td></tr>");
                $('#orderDetailsModal').modal('show');
            }
        });
    });

    // Show edit order modal
    $('.edit-order').on('click', function() {
        var orderId = $(this).data('id');
        var orderStatus = $(this).data('status');

        $('#editOrderId').val(orderId);
        $('#editOrderStatus').val(orderStatus);
        $('#editOrderModal').modal('show');
    });
});
</script>

</body>
</html>