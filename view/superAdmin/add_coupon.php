<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $expiration_date = $_POST['expiration_date'];
    $usage_limit = $_POST['usage_limit'];

    // Insert the new coupon into the database
    $insert_query = "INSERT INTO coupons (code, discount, expiration_date, usage_limit) 
                     VALUES ('$code', $discount, '$expiration_date', $usage_limit)";
    $run_insert = mysqli_query($con, $insert_query);

    if ($run_insert) {
        header("Location: view_coupons.php?message=Coupon added successfully");
    } else {
        header("Location: view_coupons.php?error=Failed to add coupon");
    }
} else {
    header("Location: view_coupons.php");
}
?>