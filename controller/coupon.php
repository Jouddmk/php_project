<?php
require_once '../db.php';
$pdo = Database::getInstance()->getConnection();
// coupon --------------------------------------

// include "config.php"; // Ensure your database connection is included

$response = "Invalid request.";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["coupon"])) {
        $couponCode = trim($_POST["coupon"]);
        if (empty($couponCode)) {
            $response = "Coupon code is required.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT discount, expiration_date FROM coupons WHERE code = :code");
                $stmt->execute(["code" => $couponCode]);
                $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($coupon) {
                    $expirationDate = $coupon["expiration_date"];
                    $currentDate = date("Y-m-d");

                    if ($expirationDate < $currentDate) {
                        $response = "Coupon is expired.;";
                    } else {
                        $response = "success;" . $coupon["discount"];
                    }
                } else {
                    $response = "Invalid coupon.;";
                }
                echo $response;
            } catch (PDOException $e) {
                $response = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>