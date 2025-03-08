let appliedCoupon = 0;
/*=============== Nav ===============*/
/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById("nav-menu"),
  navToggle = document.getElementById("nav-toggle"),
  navClose = document.getElementById("nav-close");

/* Menu show */
if (navToggle) {
  navToggle.addEventListener("click", () => {
    navMenu.classList.add("show-menu");
  });
}

/* Menu hidden */
if (navClose) {
  navClose.addEventListener("click", () => {
    navMenu.classList.remove("show-menu");
  });
}

/*=============== Nav ===============*/

// Modal functionality
document.querySelectorAll(".card__product").forEach((card) => {
  card.addEventListener("click", () => {
    const modal = document.querySelector(
      `.modal[data-id="${card.dataset.id}"]`
    );
    if (modal) modal.classList.add("active-modal");
  });
});

document.querySelectorAll(".modal__close").forEach((closeBtn) => {
  closeBtn.addEventListener("click", () => {
    document
      .querySelectorAll(".modal")
      .forEach((modal) => modal.classList.remove("active-modal"));
  });
});

document.querySelectorAll(".modal").forEach((modal) => {
  modal.addEventListener("click", (e) => {
    if (!e.target.closest(".modal__card"))
      modal.classList.remove("active-modal");
  });
});

function filterProducts() {
  let searchQuery = document.getElementById("search").value.toLowerCase();
  let products = document.querySelectorAll(".card__product");

  products.forEach((product) => {
    let productName = product.querySelector("h2").innerText.toLowerCase();
    if (productName.includes(searchQuery)) {
      product.style.display = "block";
    } else {
      product.style.display = "none";
    }
  });
}

// Cart functionality
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Selectors
const selectors = {
  cartBtn: document.querySelector(".cart-btn"),
  cartQty: document.querySelector(".cart-qty"),
  cartClose: document.querySelector(".cart-close"),
  cart: document.querySelector(".cart"),
  cartOverlay: document.querySelector(".cart-overlay"),
  cartClear: document.querySelector(".cart-clear"),
  cartBody: document.querySelector(".cart-body"),
  cartTotal: document.querySelector(".cart-total"),
};

// Event Listeners
selectors.cartBtn.addEventListener("click", () => {
  selectors.cart.classList.add("show");
  selectors.cartOverlay.classList.add("show");
  navMenu.classList.remove("show-menu");
});

selectors.cartClose.addEventListener("click", hideCart);
selectors.cartOverlay.addEventListener("click", hideCart);
selectors.cartClear.addEventListener("click", () => {
  cart = [];
  saveCart();
  renderCart();
});

// Delegated event listener for dynamically created buttons
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("add-to-cart")) {
    addToCart(parseInt(e.target.dataset.id));
    hideModal(e.target.dataset.id);
  }
  if (e.target.dataset.btn === "incr") {
    updateQuantity(
      parseInt(e.target.closest(".cart-item").dataset.id),
      "increase"
    );
  } else if (e.target.dataset.btn === "decr") {
    updateQuantity(
      parseInt(e.target.closest(".cart-item").dataset.id),
      "decrease"
    );
  }
});
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("unnuser")) {
    window.location.href = "../view/login.html";
  }
});

// Cart Functions
function hideCart() {
  selectors.cart.classList.remove("show");
  selectors.cartOverlay.classList.remove("show");
}

function hideModal(id) {
  const modal = document.querySelector(`.modal[data-id="${id}"]`);
  if (modal) modal.classList.remove("active-modal");
}

function addToCart(id) {
  let product = cart.find((item) => item.id === id);
  if (product) {
    product.qty++;
  } else {
    cart.push({ id, qty: 1 });
  }
  saveCart();
  renderCart();
}

function removeFromCart(id) {
  cart = cart.filter((item) => item.id !== id);
  saveCart();
  renderCart();
}

function updateQuantity(id, action) {
  let product = cart.find((item) => item.id === id);
  if (product) {
    action === "increase" ? product.qty++ : product.qty--;
    if (product.qty === 0) removeFromCart(id);
  }
  saveCart();
  renderCart();
}

function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

function renderCart() {
  selectors.cartBody.innerHTML = "";
  let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);

  // Update cart quantity on the cart icon
  selectors.cartQty.textContent = totalItems;
  selectors.cartQty.style.display = totalItems > 0 ? "block" : "none"; // Hide when empty

  if (cart.length === 0) {
    selectors.cartBody.innerHTML =
      "<div class='cart-empty'>Your cart is empty.</div>";
    selectors.cartTotal.textContent = "$0.00";
    return;
  }
  var total = 0;

  cart.forEach(({ id, qty }) => {
    let product = document.querySelector(`.card__product[data-id="${id}"]`);
    if (!product) return;

    let name = product.querySelector(".card__name").textContent;
    let price = parseFloat(
      product.querySelector(".card__price").textContent.replace("$", "")
    );
    let image = product.querySelector(".card__img").src;
    let amount = price * qty;
    total += amount;

    selectors.cartBody.innerHTML += `
     <div class="cart-item" data-id="${id}">
      <img src="${image}" alt="${name}" />
      <div class="cart-item-detail">
          <h3>${name}</h3>
          <h5>$${price.toFixed(2)}</h5>
          <div class="cart-item-amount">
              <button data-btn="decr" class="incr-decr">-</button>
              <span class="qty">${qty}</span>
              <button data-btn="incr" class="incr-decr">+</button>
              <span class="cart-item-price">$${amount.toFixed(2)}</span>
          </div>
      </div>
  </div>`;
  });

  // Apply discount if coupon is valid
  if (appliedCoupon) {
    total = total - (total * appliedCoupon) / 100;
  }

  selectors.cartTotal.textContent = `$${total.toFixed(2)}`;
}

// Initial render on page load
renderCart();

/*=============== Apply Coupon Function ===============*/
window.applyCoupon = async function () {
  let couponCode = document.getElementById("coupon-code").value.trim();

  if (couponCode === "") {
    document.getElementById("coupon-message").textContent =
      "Please enter a coupon code!";
    return;
  }

  let formData = new FormData();
  formData.append("coupon", couponCode);

  try {
    let response = await fetch("home.php", {
      method: "POST",
      body: formData,
    });

    let data = await response.text();

    if (data.startsWith("success")) {
      appliedCoupon = parseInt(data.split(";")[1]);
      document.getElementById(
        "coupon-message"
      ).textContent = `Coupon Applied! You got ${appliedCoupon}% off.`;
      document.getElementById("coupon-message").style.color = "green";
      document.getElementById("coupon-message").style.margin = "10px 0px";

      renderCart(); // Recalculate total price
    } else {
      document.getElementById("coupon-message").textContent =
        data.split(";")[0];
      document.getElementById("coupon-message").style.color = "red";
      document.getElementById("coupon-message").style.margin = "10px 0px ";
    }
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
    document.getElementById("coupon-message").textContent =
      "Error applying coupon. Please try again.";
    document.getElementById("coupon-message").style.color = "red";
  }
};

/*=============== categories ===============*/
const categoriesTypes = document.querySelector(".categories_types");
const arrowTypes = document.querySelector(".ri-arrow-down-s-fill");

arrowTypes.addEventListener("click", () => {
  categoriesTypes.classList.toggle("active");
});
//=================logout==================//
document.getElementById("logout-btn").addEventListener("click", () => {
  localStorage.clear();
});

//////////////////////////////////////////////
// Checkout button functionality
document.getElementById("checkoutBtn").addEventListener("click", () => {
  // Calculate the total price (with coupon discount if applied)
  let totalPrice = parseFloat(selectors.cartTotal.textContent.replace("$", ""));

  // Save the total price to local storage
  localStorage.setItem("totalPrice", totalPrice);
});
