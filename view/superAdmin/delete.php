<?php
// Include your database connection
include('db.php');

if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];

    // Validate the table name to prevent SQL injection
    $allowed_tables = ['products', 'users', 'orders', 'coupons', 'categories'];
    if (!in_array($table, $allowed_tables)) {
        die("Invalid table name.");
    }

    // Delete the row from the specified table
    $delete_query = "DELETE FROM $table WHERE id = $id";
    $run_delete = mysqli_query($con, $delete_query);

    if ($run_delete) {
        header("Location: {$_SERVER['HTTP_REFERER']}?message=Row deleted successfully");
    } else {
        header("Location: {$_SERVER['HTTP_REFERER']}?error=Failed to delete row");
    }
} else {
    header("Location: index.php");
}
?>