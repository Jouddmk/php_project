// Declare the variable in the global scope
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
// Modify renderCart function to apply discount
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
              <button data-btn="decr">-</button>
              <span class="qty">${qty}</span>
              <button data-btn="incr">+</button>
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
      renderCart(); // Recalculate total price
    } else {
      document.getElementById("coupon-message").textContent = data;
    }
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
    document.getElementById("coupon-message").textContent =
      "Error applying coupon. Please try again.";
  }
};

/*=============== categories ===============*/
categories_types = document.querySelector(".categories_types");
arrow_types = document.querySelector(".ri-arrow-down-s-fill");

arrow_types.addEventListener("click", () => {
  if (categories_types.style.display == "flex") {
    categories_types.style.display = "none";
  } else {
    categories_types.style.display = "flex";
  }
});

// ____________Checkout________________
// document.addEventListener("DOMContentLoaded", function () {
//   const checkoutButton = document.getElementById("checkout-button");
//   const modalz = document.getElementById("checkout-modal");
//   const closeButton = document.getElementById("close-button");
//   const totalPriceElement = document.getElementById("total-price");
//   const confirmButton = document.getElementById("confirm-button");

//   // Function to display total price in the modal
//   function displayTotalPrice() {
//     const totalPrice = calculateTotal(); // Assuming calculateTotal() returns the total amount
//     totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
//   }

//   checkoutButton.addEventListener("click", function () {
//     displayTotalPrice(); // Update total price before showing modal
//     modalz.style.display = "block";
//   });

//   closeButton.addEventListener("click", function () {
//     modalz.style.display = "none";
//   });

//   window.addEventListener("click", function (event) {
//     if (event.target === modalz) {
//       modalz.style.display = "none";
//     }
//   });

//   confirmButton.addEventListener("click", function () {
//     const paymentMethod = document.getElementById(
//       "payment-method-select"
//     ).value;
//     alert(
//       `Thank you for your purchase! You selected ${paymentMethod} as your payment method. Your total price is
//       ${totalPriceElement.textContent}.`
//     );
//     // You can further process the payment here
//     modalz.style.display = "none";
//   });
// });

// // Assuming your existing calculateTotal function looks something like this:
// function calculateTotal() {
//   let total = 0;
//   cart.forEach(({ id, qty }) => {
//     let product = document.querySelector(`.card__product[data-id="${id}"]`);
//     if (!product) return;

//     let price = parseFloat(
//       product.querySelector(".card__price").textContent.replace("$", "")
//     );
//     total += price * qty;
//   });

//   // Apply discount if coupon is valid
//   if (appliedCoupon) {
//     total = total - (total * appliedCoupon) / 100;
//   }

//   return total;
// }
