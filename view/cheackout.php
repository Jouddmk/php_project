<?php
session_start();

require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
  <link rel="stylesheet" href="./assets/css/checkout.css" />
</head>

<body>
  <?php require './nav.php'; ?>
  <div class="container">
    <form method="POST" action="../model/checkout.php" id="checkout-form">
      <div class="row">
        <div class="col">
          <h3 class="title">Billing Address</h3>
          <div class="inputBox">
            <span>Address :</span>
            <input type="text" placeholder="Room - Street - Locality" required />
          </div>
          <div class="inputBox">
            <span>City :</span>
            <input type="text" placeholder="Amman" required />
          </div>
        </div>

        <div class="col">
          <h3 class="title">Payment Method</h3>

          <div class="inputBox">

            <div class="pay-meth">
              <button
                type="button"
                class="payment-btn"
                id="cash-btn"
                onclick="togglePayment('cod')">
                Cash on Delivery
              </button>
              <button
                type="button"
                class="payment-btn"
                id="visa-btn"
                onclick="togglePayment('visa')">
                Pay by Visa
              </button>
            </div>
          </div>

          <div id="visa-details" class="payment-details">
            <div class="inputBox">
              <span>Cards Accepted :</span>
              <img src="./assets/img/card_img.png" alt="Cards Accepted" />
            </div>
            <div class="inputBox">
              <span>Name on Card :</span>
              <input type="text" placeholder="Mr. John Doe" />
            </div>
            <div class="inputBox">
              <span>Credit Card Number :</span>
              <input type="number" placeholder="1111-2222-3333-4444" />
            </div>
            <div class="inputBox">
              <span>Exp Month :</span>
              <input type="text" placeholder="January" />
            </div>

            <div class="flex">
              <div class="inputBox">
                <span>Exp Year :</span>
                <input type="number" placeholder="2022" />
              </div>
              <div class="inputBox">
                <span>CVV :</span>
                <input type="text" placeholder="123" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Hidden fields to hold cart data and total price -->
      <input type="hidden" name="cart" id="cart-data">
      <input type="hidden" name="totalPrice" id="total-price">

      <input type="submit" value="Proceed to Checkout" class="submit-btn" />
    </form>
  </div>

  <script>
    function togglePayment(method) {
      document.getElementById("cash-btn").style.background =
        method === "cod" ? "#c95b7a" : "#ab4e68";
      document.getElementById("visa-details").style.display =
        method === "visa" ? "block" : "none";
      document.getElementById("visa-btn").style.background =
        method === "visa" ? "#c95b7a" : "#ab4e68";
    }

    // Initialize with no payment details shown
    togglePayment("");

    let cartDataL = localStorage.getItem('cart');
    let totalPriceL = localStorage.getItem('totalPrice');
    cartDataL = JSON.parse(cartDataL);

    document.querySelector('.submit-btn').addEventListener('click', function(event) {
      // Prevent default form submission to handle it manually
      event.preventDefault();

      // Assuming you have cartData and totalPrice variables
      var cartData = cartDataL;
      var totalPrice = totalPriceL;

      // Set the values of the hidden input fields
      document.getElementById('cart-data').value = JSON.stringify(cartData);
      document.getElementById('total-price').value = totalPrice;

      // Submit the form after setting the hidden fields
      document.querySelector('form').submit();
      localStorage.clear();
    });
  </script>
</body>

</html>