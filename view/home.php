<?php
session_start();
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
   $role = $_SESSION['role'];
}

require_once '../db.php';
$pdo = Database::getInstance()->getConnection();

// Fetch categories from the database
$categoryStmt = $pdo->prepare("SELECT id, name FROM categories");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products based on category or search
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$productStmt = $pdo->prepare("SELECT * FROM products WHERE (:search = '' OR name LIKE :search) AND (:category = '' OR category_id = :category)");
$productStmt->execute(['search' => "%$search%", 'category' => $category]);
$products = $productStmt->fetchAll(PDO::FETCH_ASSOC);

$newArrivalStmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT 3");
$newArrivalStmt->execute();
$newArrivals = $newArrivalStmt->fetchAll(PDO::FETCH_ASSOC);


require '../controller/coupon.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous" /> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

   <!--=============== REMIXICONS ===============-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">

   <!--=============== BootstrapIcon ===============-->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

   <link rel="stylesheet" href="./assets/css/home.css">

   <style>
      #hideelement {
         display: none;
      }
   </style>

   <title>Flower-store</title>
</head>

<body>

   <header class="header" id="header">
      <nav class="nav nav-container">
         <a href="#" class="nav__logo">Flower <span class="logo-span">.</span></a>

         <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
               <li class="nav__item">
                  <a href="#" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Home</span>
                  </a>
               </li>

               <li class="nav__item">
                  <a href="#about" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>About</span>
                  </a>
               </li>




               <li class="nav__item">
                  <a href="#con" class="nav__link">
                     <i class="ri-arrow-right-up-line"></i>
                     <span>Contact Us</span>
                  </a>
               </li>

               <?php
               if (isset($_SESSION['user_id'])) {
                  if ($role == "admin")
                     echo
                     "<li class='nav__item'>
                  <a href='./admin/index.php' class='nav__link'>
                     <i class='ri-arrow-right-up-line'></i>
                     <span>AdminDB</span>
                  </a>
               </li> ";
                  elseif ($role == "super_admin") {
                     echo
                     "<li class='nav__item'>
                  <a href='./superAdmin/index.php' class='nav__link'>
                     <i class='ri-arrow-right-up-line'></i>
                     <span>SAdminDB</span>
                  </a>
               </li> ";
                  }
               }
               ?>

            </ul>

            <!-- Close button -->
            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
               <div class="nav__close" id="nav-close">
                  <i class="ri-close-large-line"></i>
               </div>

               <div class="nav__social">
                  <a href="#" class="nav__social-link cart-btn">
                     <i class="ri-shopping-cart-2-fill"><small class="cart-qty">0</small></i>
                  </a>

                  <a href="./profile.php" class="nav__social-link">
                     <i class="ri-user-fill"></i>
                  </a>

                  <a href="../controller/logout.php" id="logout-btn" class="nav__social-link">
                     <i class="ri-logout-box-r-fill"></i>
                  </a>
               <?php
            } else { ?>

                  <a href="../controller/logout.php" class="nav__social-link">
                     <i class="ri-login-box-fill"></i>
                  </a>

                  <a href="#" id="hideelement" class="nav__social-link cart-btn">
                     <i class="ri-shopping-cart-2-fill"><small class="cart-qty">0</small></i>
                  </a>

               <?php
            }
               ?>
               </div>
         </div>

         <!-- Toggle button -->
         <div class="nav__toggle" id="nav-toggle">
            <i class="ri-menu-line"></i>
         </div>
      </nav>
   </header>

   <!--==================== MAIN ====================-->
   <main>
      <?php require "./hero.php" ?>
      <!-- Categories Section -->
      <section class="crd-container">
         <div class="categories">
            <h3 class="cat-head">Categories <i class="ri-arrow-down-s-fill"></i></h3>
            <ul class="categories_types">
               <li>
                  <a href="home.php?category=" class="category-link">All</a>
               </li>
               <?php foreach ($categories as $category): ?>
                  <li>
                     <a href="home.php?category=<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                     </a>
                  </li>
               <?php endforeach; ?>
            </ul>
            <form class="search" method="GET" action="home.php">
               <input class="input" type="text" name="search" placeholder="Search for flowers...">
               <button class="btn" type="submit"><i class="fas fa-search "></i></button>
            </form>

         </div>


         <!-- ____________search bar___________ -->


         <div class="card__container">
            <?php
            $i = 0;
            foreach ($products as $product):
               if ($i++ > 5) {
                  break;
               }
            ?>
               <article>
                  <div class="card__product" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="card__img">
                     <div>
                        <h3 class="card__name"><?= htmlspecialchars($product['name']) ?></h3>
                        <span class="card__price">$<?= number_format($product['price'], 2) ?></span>
                     </div>
                  </div>

                  <div class="modal" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <div class="modal__card">
                        <i class="bi bi-x-circle modal__close"></i>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="modal__img">
                        <div>
                           <h3 class="modal__name"><?= htmlspecialchars($product['name']) ?></h3>
                           <p class="modal__info"><?= htmlspecialchars($product['description']) ?></p>
                           <span class="modal__price">$<?= number_format($product['price'], 2) ?></span>
                        </div>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                        ?>
                           <div class="modal__buttons">
                              <button class="modal__button add-to-cart" data-id="<?= htmlspecialchars($product['id']) ?>">Add to Cart</button>
                           </div>
                        <?php
                        } else {
                        ?>
                           <div class="modal__buttons">
                              <button class="modal__button unnuser" data-id="<?= htmlspecialchars($product['id']) ?>">Add to Cart</button>
                           </div>
                        <?php
                        }
                        ?>
                     </div>
                  </div>
               </article>
            <?php endforeach; ?>
         </div>
      </section>
      <!-- new arrivel  -->
      <section class="new-arrivals">
         <h2 class="section-title">New Arrivals</h2>
         <div class="card__container">
            <?php foreach ($newArrivals as $product): ?>
               <article>
                  <div class="card__product" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="card__img">
                     <div>
                        <h3 class="card__name"><?= htmlspecialchars($product['name']) ?></h3>
                        <span class="card__price">$<?= number_format($product['price'], 2) ?></span>
                     </div>
                  </div>
                  <div class="modal" data-id="<?= htmlspecialchars($product['id']) ?>">
                     <div class="modal__card">
                        <i class="bi bi-x-circle modal__close"></i>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="modal__img">
                        <div>
                           <h3 class="modal__name"><?= htmlspecialchars($product['name']) ?></h3>
                           <p class="modal__info"><?= htmlspecialchars($product['description']) ?></p>
                           <span class="modal__price">$<?= number_format($product['price'], 2) ?></span>
                        </div>
                        <?php
                        if (isset($_SESSION['user_id'])) {
                        ?>
                           <div class="modal__buttons">
                              <button class="modal__button add-to-cart" data-id="<?= htmlspecialchars($product['id']) ?>">Add to Cart</button>
                           </div>
                        <?php
                        } else {
                        ?>
                           <div class="modal__buttons">
                              <button class="modal__button unnuser" data-id="<?= htmlspecialchars($product['id']) ?>">Add to Cart</button>
                           </div>
                        <?php
                        }
                        ?>
                     </div>
                  </div>
               </article>

            <?php endforeach; ?>
         </div>
      </section>
      <!-- end new arrivel  -->
   </main>

   <!--=============== cart ===============-->
   <div class="cart-overlay"></div>
   <div class="cart">
      <div class="cart-header">
         <i class="bi bi-arrow-right cart-close"></i>
         <h2>Your Cart</h2>
      </div>
      <div class="cart-body"></div>
      <div class="cart-footer">
         <div>
            <strong>Total</strong>
            <span class="cart-total">0</span>
         </div>

         <!-- coupon  -->
         <div class="coupon-section">
            <input type="text" id="coupon-code" placeholder="Enter Coupon Code">
            <button id="coupon-apply" onclick="applyCoupon()">Apply Coupon</button>
            <p id="coupon-message"></p>
         </div>
         <!-- end coupon  -->

         <button class="cart-clear">Clear Cart</button>
         <a href="./cheackout.php"><button class="checkout" id="checkoutBtn">Checkout</button></a>
      </div>
   </div>

   <section id="about"><?php
                        require "./about.php"; ?></section>
   <section id="con"><?php
                     require "./contact.php"; ?></section>
   <section id="footer"><?php
                        require "./footer.php";
                        ?></section>



   <!--=============== MAIN JS ===============-->
   <script src="./assets/js/home.js"></script>
</body>

</html>