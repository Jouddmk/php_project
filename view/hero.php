<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>home</title>

  <!-- <link rel="stylesheet" href="./style.css" /> -->

  <style>
    /* General Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Carousel Container */
    .carousel {
      position: relative;
      width: 100%;
      overflow: hidden;
    }

    .carousel-inner {
      position: relative;
      width: 100%;
      display: flex;
    }

    .carousel-item {
      position: relative;
      width: 100%;
      flex: 0 0 100%;
      transition: transform 0.6s ease-in-out;
    }

    .carousel-item img {
      width: 100%;
      height: 80vh;
      object-fit: cover;
      filter: blur(1px);
      margin-top: 100px;
    }

    /* Active Carousel Item */
    .carousel-item.active {
      display: block;
    }

    /* Carousel Caption */
    .carousel-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 80%;
      transform: translate(-50%, -30%);
      text-align: center;
    }

    .sh {
      font-size: calc(1.5rem + 1.5vw);
      text-shadow: 1px 1px black;
      color: #ffffff;
    }

    .p {
      margin: 3vh 0;
      font-size: calc(1rem + 0.5vw) !important;
    }

    .hero-btn {
      padding: 10px 20px;
      background-color: transparent;
      backdrop-filter: blur(40px);
      border-radius: 50px;
      font-size: calc(0.8rem + 0.5vw);
      border: 2px solid white;
      cursor: pointer;
    }

    .hero-btn a {
      color: #ffffff;
      text-shadow: 2px 2px black;
      text-decoration: none;
    }

    /* Button Hover Effect */
    .view-btn {
      transition: background-color 0.3s ease, color 0.3s ease;
      border-radius: 5px;
    }

    .view-btn:hover {
      background-color: #007bff !important;
      color: white !important;
    }

    /* Carousel Controls */
    .carousel-control-prev,
    .carousel-control-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 5%;
      height: 50px;
      background: transparent;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .carousel-control-prev {
      left: 10px;
    }

    .carousel-control-next {
      right: 10px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      width: 20px;
      height: 20px;
      background-color: white;
      mask-size: cover;
      -webkit-mask-size: cover;
    }

    .carousel-control-prev-icon {
      mask-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'><path d='M5 0l-4 4 4 4v-8z' fill='%23000'/></svg>");
      -webkit-mask-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'><path d='M5 0l-4 4 4 4v-8z' fill='%23000'/></svg>");
    }

    .carousel-control-next-icon {
      mask-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'><path d='M3 0v8l4-4-4-4z' fill='%23000'/></svg>");
      -webkit-mask-image: url("data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'><path d='M3 0v8l4-4-4-4z' fill='%23000'/></svg>");
    }

    .carousel-item {
      display: none;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }

    .carousel-item.active {
      display: block;
      opacity: 1;
    }


    /* Responsive Design */
    @media (max-width: 576px) {
      .carousel-item img {
        height: 50vh;
      }
    }
  </style>
</head>

<body>
  <header
    id="heroCarousel"
    class="carousel slide carousel-fade"
    data-bs-ride="carousel"
    data-bs-interval="3000">


    <div class="carousel-inner">
      <div class="carousel-item active">
        <img
          src="../Banner_Seeds_A-to-Z-1440x581_1300x.jpg"
          class="d-block w-100"
          alt="Beautiful Flowers" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold sh">Welcome to Flower Shop</h1>
          <p class="text-white sh p">Find the most beautiful flowers for your loved ones</p>
          <button class="hero-btn"><a href="#">Shop Now</a></button>
        </div>
      </div>

      <div class="carousel-item">
        <img
          src="https://library.floretflowers.com/cdn/shop/collections/Floret-Library-daffodils-collection-banner-sm_1300x.jpg?v=1681916110"
          class="d-block w-100"
          alt="Fresh Flowers" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold sh">Fresh & Beautiful Flowers</h1>
          <p class="text-white sh p">We deliver fresh flowers to your doorstep</p>
          <button class="hero-btn"><a href="#">Shop Now</a></button>
        </div>
      </div>

      <div class="carousel-item">
        <img
          src="https://library.floretflowers.com/cdn/shop/collections/Floret-shop-floret-originals-dahlias-banner_1300x.jpg?v=1708027750"
          class="d-block w-100"
          alt="Flower Bouquets" />
        <div class="carousel-caption">
          <h1 class="text-white fw-bold sh">Special Flower Bouquets</h1>
          <p class="text-white sh p">Order custom flower arrangements</p>
          <button class="hero-btn"><a href="#">Shop Now</a></button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

</body>

</html>