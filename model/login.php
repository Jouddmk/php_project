<?php
session_start();
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (!password_verify($password, $user['password'])) {
                $_SESSION['error_password'] = "Incorrect password";
                header("Location: ../view/login.html");
                exit();
            }

            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'super_admin') {
                header("Location: ../view/home.php");
            } elseif ($user['role'] === 'admin') {
                header("Location: ../view/home.php");
            } else {
                header("Location: ../view/home.php");
            }
            exit();
        }

        $_SESSION['error_email'] = "Email doesn't exist";
        header("Location: ../view/login.html");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
