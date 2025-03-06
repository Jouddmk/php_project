<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update the user in the database
    $update_query = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
    $run_update = mysqli_query($con, $update_query);

    if ($run_update) {
        header("Location: users.php?message=User updated successfully");
    } else {
        header("Location: users.php?error=Failed to update user");
    }
} else {
    header("Location: users.php");
}
?>