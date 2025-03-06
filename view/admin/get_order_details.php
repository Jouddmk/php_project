<?php
include('db.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $query = "
        SELECT order_items.order_id, order_items.quantity, order_items.price, products.name, products.image
        FROM order_items
        JOIN products ON order_items.product_id = products.id
        WHERE order_items.order_id = $order_id
    ";

    $result = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$row['order_id']}</td>
                <td>{$row['quantity']}</td>
                <td>{$row['price']}</td>
                <td>{$row['name']}</td>
                <td><img src='{$row['image']}' width='50'></td>
              </tr>";
    }
}
?>