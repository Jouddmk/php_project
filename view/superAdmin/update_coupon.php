<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $expiration_date = $_POST['expiration_date'];
    $usage_limit = $_POST['usage_limit'];

    // Update the coupon in the database
    $update_query = "UPDATE coupons SET code='$code', discount=$discount, expiration_date='$expiration_date', usage_limit=$usage_limit WHERE id=$id";
    $run_update = mysqli_query($con, $update_query);

    if ($run_update) {
        header("Location: view_coupons.php?message=Coupon updated successfully");
    } else {
        header("Location: view_coupons.php?error=Failed to update coupon");
    }
} else {
    header("Location: view_coupons.php");
}
?>