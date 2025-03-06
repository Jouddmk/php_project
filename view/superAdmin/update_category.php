<?php
// Include your database connection
session_start();


include('db.php');


$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "category_images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        // Keep the existing image if no new image is uploaded
        $query = "SELECT image FROM categories WHERE id = $id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
    }

    // Update the category in the database
    $update_query = "UPDATE categories SET name='$name', image='$image' WHERE id=$id";
    $run_update = mysqli_query($con, $update_query);

    if ($run_update) {
        header("Location: view_categories.php?message=Category updated successfully");
    } else {
        header("Location: view_categories.php?error=Failed to update category");
    }
} else {
    header("Location: view_categories.php");
}
?>