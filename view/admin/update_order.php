<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Update the order status in the database
    $update_query = "UPDATE orders SET status='$status' WHERE id=$id";
    $run_update = mysqli_query($con, $update_query);

    if ($run_update) {
        header("Location: view_orders.php?message=Order updated successfully");
    } else {
        header("Location: view_orders.php?error=Failed to update order");
    }
} else {
    header("Location: view_orders.php");
}
?>