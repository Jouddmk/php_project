<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "product_images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        // Keep the existing image if no new image is uploaded
        $query = "SELECT image FROM products WHERE id = $id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
    }

    // Update the product in the database
    $update_query = "UPDATE products SET name='$name', description='$description', price=$price, stock=$stock, category_id=$category_id, image='$image' WHERE id=$id";
    $run_update = mysqli_query($con, $update_query);

    if ($run_update) {
        header("Location: product.php?message=Product updated successfully");
    } else {
        header("Location: product.php?error=Failed to update product");
    }
} else {
    header("Location: product.php");
}
?>