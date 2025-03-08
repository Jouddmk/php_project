<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>home</title>
  <link rel="stylesheet" href="./style.css" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <style>
    #heroCarousel .carousel-inner img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    .view-btn {
      transition: background-color 0.3s ease, color 0.3s ease;
      border-radius: 5px;
    }

    .view-btn:hover {
      background-color: #007bff !important;
      color: white !important;
    }

    /* 
    .card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .product-img {
      object-fit: cover;
      height: 350px;
    }

    .card-body {
      padding: 1.25rem;
    } */
  </style>
</head>

<body>

  <header
    id="heroCarousel"
    class="carousel slide carousel-fade"
    data-bs-ride="carousel"
    data-bs-interval="3000">
    <div class="carousel-indicators">
      <button
        type="button"
        data-bs-target="#heroCarousel"
        data-bs-slide-to="0"
        class="active"></button>
      <button
        type="button"
        data-bs-target="#heroCarousel"
        data-bs-slide-to="1"></button>
      <button
        type="button"
        data-bs-target="#heroCarousel"
        data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img
          src="./Banner_Seeds_A-to-Z-1440x581_1300x.jpg"
          class="d-block w-100 "
          alt="Beautiful Flowers" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold">Welcome to Flower Shop</h1>
          <p class="text-white">
            Find the most beautiful flowers for your loved ones
          </p>
          <a href="#" class="btn btn-light">Shop Now</a>
        </div>
      </div>

      <div class="carousel-item">
        <img
          src="https://library.floretflowers.com/cdn/shop/collections/Floret-Library-daffodils-collection-banner-sm_1300x.jpg?v=1681916110"
          class="d-block w-100 "
          alt="Fresh Flowers" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold">Fresh & Beautiful Flowers</h1>
          <p class="text-white">We deliver fresh flowers to your doorstep</p>
          <a href="#" class="btn btn-light">Explore</a>
        </div>
      </div>

      <div class="carousel-item">
        <img
          src="https://library.floretflowers.com/cdn/shop/collections/Floret-shop-floret-originals-dahlias-banner_1300x.jpg?v=1708027750"
          class="d-block w-100"
          alt="Flower Bouquets" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold">Special Flower Bouquets</h1>
          <p class="text-white">Order custom flower arrangements</p>
          <a href="#" class="btn btn-light">Order Now</a>
        </div>
      </div>
    </div>

    <button
      class="carousel-control-prev"
      type="button"
      data-bs-target="#heroCarousel"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button
      class="carousel-control-next"
      type="button"
      data-bs-target="#heroCarousel"
      data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </header>

  <?php
  require_once './db.php';
  $pdo = Database::getInstance()->getConnection();

  try {
    $sql = "SELECT * FROM products WHERE created_at >= CURDATE() - INTERVAL 7 DAY ORDER
    BY created_at DESC LIMIT 4";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo '
    <h2 class="text-center my-4">New Arrivals</h2>
    ';
      echo '
    <div class="container">
      ';
      echo '
      <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
        ';
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $product) {
        echo '
        <div class="col d-flex justify-content-center">
          ';
        echo '
          <div
            class="card card-hover shadow-sm border-light position-relative"
            style="width: 20rem; transition: transform 0.3s ease"
          >
            ';
        echo ' <a href="register.php" class="stretched-link"></a>';
        echo '
            <img
              src="' . htmlspecialchars($product['image']) . '"
              class="card-img-top product-img"
              alt="' . htmlspecialchars($product['name']) . '"
              style="height: 350px; object-fit: cover"
            />';
        echo '
            <div class="card-body text-center">
              ';
        echo '
              <h5 class="card-title">
                ' . htmlspecialchars($product['name']) . '
              </h5>
              ';
        echo '
              <p class="card-text">
                ' . htmlspecialchars($product['description']) . '
              </p>
              ';
        echo '
              <p>
                <strong
                  >Price: $' . htmlspecialchars($product['price']) . '</strong
                >
              </p>
              ';
        echo '
              <p>
                <strong
                  >Stock: ' . htmlspecialchars($product['stock']) . '</strong
                >
              </p>
              ';
        echo '
              <a href="register.php" class="btn btn-outline-dark view-btn"
                >View Details</a
              >';
        echo '
            </div>
            ';
        echo '
          </div>
          ';
        echo '
        </div>
        ';
      }
      echo '
      </div>
      ';
      echo '
    </div>
    ';
    }
    $sql = "SELECT * FROM products ORDER
    BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo '
    <h2 class="text-center my-4">All Products</h2>
    ';
      echo '
    <div class="container">
      ';
      echo '
      <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
        ';
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $product) {
        echo '
        <div class="col d-flex justify-content-center">
          ';
        echo '
          <div
            class="card card-hover shadow-sm border-light position-relative"
            style="width: 20rem; transition: transform 0.3s ease"
          >
            ';
        echo ' <a href="register.php" class="stretched-link"></a>';
        echo '
            <img
              src="' . htmlspecialchars($product['image']) . '"
              class="card-img-top product-img"
              alt="' . htmlspecialchars($product['name']) . '"
              style="height: 350px; object-fit: cover"
            />';
        echo '
            <div class="card-body text-center">
              ';
        echo '
              <h5 class="card-title">
                ' . htmlspecialchars($product['name']) . '
              </h5>
              ';
        echo '
              <p class="card-text">
                ' . htmlspecialchars($product['description']) . '
              </p>
              ';
        echo '
              <p>
                <strong
                  >Price: $' . htmlspecialchars($product['price']) . '</strong
                >
              </p>
              ';
        echo '
              <p>
                <strong
                  >Stock: ' . htmlspecialchars($product['stock']) . '</strong
                >
              </p>
              ';
        echo '
              <a href="register.php" class="btn btn-outline-dark view-btn"
                >View Details</a
              >';
        echo '
            </div>
            ';
        echo '
          </div>
          ';
        echo '
        </div>
        ';
      }
      echo '
      </div>
      ';
      echo '
    </div>
    ';
    } else {
      echo '
    <p class="text-center">No products available.</p>';
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $pdo = null; ?>

  <!-- إضافة الـ CSS لتأثير الـ hover على كامل البطاقة -->




  <?php
  require "./about.php";
  require "./view/footer.php";
  ?>

  <!-- <section class="about-section">
    <h2>Flower Experts</h2>
    <p>A perfect blend of creativity, energy, communication, happiness and love. Let us arrange a smile for you.</p>
    <div class="team">
      <div class="team-member">
        <img src="image1.jpg" alt="Crystal Brooks">
        <h3>CRYSTAL BROOKS</h3>
        <p>Florist</p>
      </div>
      <div class="team-member">
        <img src="image2.jpg" alt="Shirley Harris">
        <h3>SHIRLEY HARRIS</h3>
        <p>Manager</p>
      </div>
      <div class="team-member">
        <img src="image3.jpg" alt="Beverly Clark">
        <h3>BEVERLY CLARK</h3>
        <p>Florist</p>
      </div>
      <div class="team-member">
        <img src="image4.jpg" alt="Amanda Watkins">
        <h3>AMANDA WATKINS</h3>
        <p>Florist</p>
      </div>
    </div>
  </section> -->

  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
  <script>
    (function() {
      emailjs.init("TrsOft_jICljuzHE7");
    })();
    document.addEventListener("DOMContentLoaded", function() {
      document
        .getElementById("contact-form")
        .addEventListener("submit", function(event) {
          event.preventDefault();

          let name = document.getElementById("name").value.trim();
          let email = document.getElementById("email").value.trim();
          let phone = document.getElementById("phone").value.trim();
          let subject = document.getElementById("subject").value.trim();
          let message = document.getElementById("message").value.trim();
          let responseMessage = document.getElementById("responseMessage");
          let submitButton = document.querySelector("#contact-form button");

          if (!name || !email || !message) {
            responseMessage.innerText =
              "❌ Please fill in all required fields.";
            responseMessage.style.color = "red";
            return;
          }

          submitButton.innerHTML = "Sending...";
          submitButton.disabled = true;

          let params = {
            name,
            email,
            phone,
            subject,
            message
          };

          emailjs
            .send("service_9zxb17c", "template_altw3bc", params)
            .then(function(response) {
              console.log("✅ Email sent successfully!", response);

              responseMessage.innerText = "✅ Message sent successfully!";
              responseMessage.style.color = "green";

              document.getElementById("contact-form").reset();

              setTimeout(() => {
                responseMessage.innerText = "";
              }, 5000);
            })
            .catch(function(error) {
              console.error("❌ Failed to send email", error);
              responseMessage.innerText =
                "❌ Failed to send message. Please try again.";
              responseMessage.style.color = "red";
            })
            .finally(function() {
              submitButton.innerHTML = "Send Message";
              submitButton.disabled = false;
            });
        });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>