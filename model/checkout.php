<?php
session_start();

require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

////////////////////////////////////
// process.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cartData = json_decode($_POST['cart'], true);  // Decode the cart data (it's a JSON string)
  $totalPrice = $_POST['totalPrice'];

  // Example: Insert cart data into a database (you can modify this to fit your structure)
  $sql1 = "SELECT MAX(id) AS latest_id FROM orders"; 
  $stmt1 = $pdo->prepare($sql1);
  $stmt1->execute();
  $latestOrderId = $stmt1->fetchColumn();
  $latestOrderId++;

  $sql = "INSERT INTO orders (id, user_id, total_price) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$latestOrderId, $user_id, $totalPrice]);

  foreach ($cartData as $item) {
    $id = $item['id'];
    $qty = $item['qty'];

    $sql1 = "SELECT price FROM products WHERE id = ?";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$id]);
    $productPrice = $stmt1->fetchColumn();

    $sql2 = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$latestOrderId, $id, $qty, $productPrice]);
  }
  header("Location: ../view/home.php");
exit();
}

//   echo "Data received and inserted successfully.";
// } else {
//   echo "Cart or totalPrice not received.";
// }
?>
