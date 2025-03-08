<style>
  /*=============== GOOGLE FONTS ===============*/
  @import url("https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;500&display=swap");

  /*=============== VARIABLES CSS ===============*/
  :root {
    --header-height: 3.5rem;

    /*========== Colors ==========*/
    /*Color mode HSL(hue, saturation, lightness)*/
    --white-color: hsl(0, 0%, 100%);
    --black-color: hsl(0, 0%, 0%);
    --primery-color: #ab4e68;
    --bg-color: #f4b5c7;

    /*========== Font and typography ==========*/
    /*.5rem = 8px | 1rem = 16px ...*/
    --body-font: "Montserrat Alternates", sans-serif;
    --normal-font-size: 0.938rem;
    --h1-font-size: 1.5rem;
    --h2-font-size: 1.25rem;
    --h3-font-size: 1rem;

    /*========== Font weight ==========*/
    --font-regular: 400;
    --font-medium: 500;
    --font-semi-bold: 600;
    --font-bold: 700;

    /*========== z index ==========*/
    --z-tooltip: 10;
    --z-fixed: 100;
    --z-normal: 1;
    --z-modal: 1000;
  }

  /*========== Responsive typography ==========*/
  @media screen and (min-width: 1150px) {
    :root {
      --h1-font-size: 2.25rem;
      --h2-font-size: 1.5rem;
      --h3-font-size: 1.25rem;
      --normal-font-size: 1rem;
    }
  }

  /*=============== BASE ===============*/
  * {
    box-sizing: border-box;
    padding: 0;
    margin: 0;
  }

  html {
    scroll-behavior: smooth;
  }

  body {
    font-family: var(--body-font);
    font-size: var(--normal-font-size);
    background-color: var(--white-color);
  }

  /* --------------------nav---------------------------- */
  ul {
    list-style: none;
  }

  a {
    text-decoration: none;
  }

  /*=============== REUSABLE CSS CLASSES ===============*/
  .custom-nav-container {
    max-width: 1120px;
    margin-inline: 1.5rem;
  }

  /*=============== HEADER & NAV ===============*/
  .custom-header {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: var(--white-color);
    z-index: var(--z-fixed);
  }

  .custom-nav {
    position: relative;
    height: var(--header-height);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .custom-nav__logo {
    color: var(--black-color);
    font-weight: var(--font-bold);
    font-size: var(--h1-font-size);
  }

  .custom-logo-span {
    color: var(--primery-color);
  }

  .custom-nav__close,
  .custom-nav__toggle {
    display: flex;
    color: var(--black-color);
    font-size: 1.5rem;
    cursor: pointer;
  }

  /* Navigation for mobile devices */
  @media screen and (max-width: 1150px) {
    .custom-nav__menu {
      position: fixed;
      left: -100%;
      top: 0;
      background-color: var(--white-color);
      width: 100%;
      height: 100%;
      padding: 6rem 3.5rem 4.5rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: left 0.4s;
    }

    .custom-nav__item {
      transform: translateX(-150px);
      visibility: hidden;
      transition: transform 0.4s ease-out, visibility 0.4s;
    }

    .custom-nav__item:nth-child(1) {
      transition-delay: 0.1s;
    }

    .custom-nav__item:nth-child(2) {
      transition-delay: 0.2s;
    }

    .custom-nav__item:nth-child(3) {
      transition-delay: 0.3s;
    }

    .custom-nav__item:nth-child(4) {
      transition-delay: 0.4s;
    }

    .custom-nav__item:nth-child(5) {
      transition-delay: 0.5s;
    }
  }

  .custom-nav__list,
  .custom-nav__social {
    display: flex;
  }

  .custom-nav__list {
    flex-direction: column;
    row-gap: 3rem;
  }

  .custom-nav__link {
    position: relative;
    color: var(--black-color);
    font-size: var(--h1-font-size);
    font-weight: var(--font-medium);
    display: inline-flex;
    align-items: center;
    transition: opacity 0.4s;
  }

  .custom-nav__link i {
    font-size: 2rem;
    position: absolute;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s, visibility 0.4s;
  }

  .custom-nav__link span {
    position: relative;
    transition: margin 0.4s;
  }

  .custom-nav__link span::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background-color: var(--black-color);
    transition: width 0.4s ease-out;
  }

  /* Animation link on hover */
  .custom-nav__link:hover span {
    margin-left: 2.5rem;
    color: var(--black-color);
  }

  .custom-nav__link:hover i {
    opacity: 1;
    visibility: visible;
    color: var(--black-color);
  }

  .custom-nav__link:hover span::after {
    width: 100%;
  }

  /* Sibling fade animation */
  .custom-nav__list:has(.custom-nav__link:hover) .custom-nav__link:not(:hover) {
    opacity: 0.4;
    color: var(--black-color);
  }

  .custom-nav__close {
    position: absolute;
    top: 1rem;
    right: 1.5rem;
  }

  .custom-nav__social {
    column-gap: 1rem;
  }

  .custom-nav__social-link {
    color: var(--black-color);
    font-size: 1.5rem;
    transition: transform 0.4s;
  }

  .custom-nav__social-link:hover {
    transform: translateY(-0.25rem);
    text-decoration: none;
    color: var(--black-color);
  }

  a:hover {
    color: var(--black-color);
    text-decoration: none;
  }

  /* Show menu */
  .custom-show-menu {
    left: 0;
  }

  /* Animation link when displaying menu */
  .custom-show-menu .custom-nav__item {
    visibility: visible;
    transform: translateX(0);
  }

  /*=============== BREAKPOINTS ===============*/
  /* For large devices */
  @media screen and (min-width: 1150px) {
    .custom-nav-container {
      margin-inline: auto;
    }

    .custom-nav {
      height: calc(var(--header-height) + 2rem);
    }

    .custom-nav__toggle,
    .custom-nav__close {
      display: none;
    }

    .custom-nav__link {
      font-size: var(--normal-font-size);
    }

    .custom-nav__link i {
      font-size: 1.5rem;
    }

    .custom-nav__list {
      flex-direction: row;
      column-gap: 3.5rem;
    }

    .custom-nav__menu {
      display: flex;
      align-items: center;
      column-gap: 3.5rem;
    }
  }

  /* --------------------nav---------------------------- */
</style>
<header class="custom-header" id="header">
  <nav class="custom-nav custom-nav-container">
    <a href="#" class="custom-nav__logo">Flower <span class="custom-logo-span">.</span></a>

    <div class="custom-nav__menu" id="nav-menu">
      <ul class="custom-nav__list">
        <li class="custom-nav__item">
          <a href="./home.php" class="custom-nav__link">
            <i class="ri-arrow-right-up-line"></i>
            <span>Home</span>
          </a>
        </li>

        <li class="custom-nav__item">
          <a href="./home.php#about" class="custom-nav__link">
            <i class="ri-arrow-right-up-line"></i>
            <span>About</span>
          </a>
        </li>



        <li class="custom-nav__item">
          <a href="./home.php#con" class="custom-nav__link">
            <i class="ri-arrow-right-up-line"></i>
            <span>Contact</span>
          </a>
        </li>

        <?php
        if ($role == "admin")
          echo
          "<li class='custom-nav__item'>
                  <a href='#' class='custom-nav__link'>
                     <i class='ri-arrow-right-up-line'></i>
                     <span>AdminDB</span>
                  </a>
               </li> ";
        elseif ($role == "super_admin") {
          echo
          "<li class='custom-nav__item'>
                  <a href='#' class='custom-nav__link'>
                     <i class='ri-arrow-right-up-line'></i>
                     <span>SAdminDB</span>
                  </a>
               </li> ";
        }
        ?>
      </ul>

      <!-- Close button -->
      <div class="custom-nav__close" id="nav-close">
        <i class="ri-close-large-line"></i>
      </div>

      <div class="custom-nav__social">


        <a href="./profile.php" class="custom-nav__social-link">
          <i class="ri-user-fill"></i>
        </a>

        <a href="../controller/logout.php" id="logout-btn" class="custom-nav__social-link">
          <i class="ri-logout-box-r-fill"></i>
        </a>

      </div>
    </div>

    <!-- Toggle button -->
    <div class="custom-nav__toggle" id="nav-toggle">
      <i class="ri-menu-line"></i>
    </div>
  </nav>
</header>
<script>
  const navMenu = document.getElementById("nav-menu"),
    navToggle = document.getElementById("nav-toggle"),
    navClose = document.getElementById("nav-close");

  /* Menu show */
  if (navToggle) {
    navToggle.addEventListener("click", () => {
      navMenu.classList.add("custom-show-menu");
    });
  }

  /* Menu hidden */
  if (navClose) {
    navClose.addEventListener("click", () => {
      navMenu.classList.remove("custom-show-menu");
    });
  }
  document.getElementById("logout-btn").addEventListener("click", () => {
    localStorage.clear();
  });
</script>