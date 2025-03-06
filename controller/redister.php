<?php
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = trim($_POST['phone']);
    $location = trim($_POST['location']);
    $role = 'customer'; // Default role
    $image = "default.png"; // Default profile image

    // Check if email is already registered
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Email already registered!";
    } else {
        // Insert user with default image
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone, address, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $email, $password, $phone, $location, $image, $role])) {
            header("Location: ../view/login.html");
            exit();
        } else {
            echo "Error during registration.";
        }
    }
}
?>
