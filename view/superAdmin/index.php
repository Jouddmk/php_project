<?php
session_start();


include('db.php');


$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];


// Fetch some data for the dashboard
$total_products = 0;
$total_users = 0;
$total_orders = 0;
$total_categories = 0;

// Example queries (replace with your actual queries)
$result = mysqli_query($con, "SELECT COUNT(*) as total FROM products");
if ($row = mysqli_fetch_assoc($result)) {
    $total_products = $row['total'];
}

$result = mysqli_query($con, "SELECT COUNT(*) as total FROM users");
if ($row = mysqli_fetch_assoc($result)) {
    $total_users = $row['total'];
}

$result = mysqli_query($con, "SELECT COUNT(*) as total FROM orders");
if ($row = mysqli_fetch_assoc($result)) {
    $total_orders = $row['total'];
}

$result = mysqli_query($con, "SELECT COUNT(*) as total FROM categories");
if ($row = mysqli_fetch_assoc($result)) {
    $total_categories = $row['total'];
}
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
        <div class="sidebar-heading text-white">Super Admin Dashboard</div>
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
        <div class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <h2>Welcome to the Super Admin Dashboard</h2>
        </div>

        <div class="container-fluid">
            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text"><?php echo $total_products; ?></p>
                            <a href="product.php" class="btn btn-primary btn-sm">View Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text"><?php echo $total_users; ?></p>
                            <a href="users.php" class="btn btn-primary btn-sm">View Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text"><?php echo $total_orders; ?></p>
                            <a href="view_orders.php" class="btn btn-primary btn-sm">View Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Categories</h5>
                            <p class="card-text"><?php echo $total_categories; ?></p>
                            <a href="view_categories.php" class="btn btn-primary btn-sm">View Categories</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Recent Activities</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Activity</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example data -->
                                    <tr>
                                        <td>1</td>
                                        <td>New order placed</td>
                                        <td>2023-10-01</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>User registered</td>
                                        <td>2023-10-02</td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and JQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>