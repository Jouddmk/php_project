document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const nameField = document.querySelector("[name='name']");
  const emailField = document.querySelector("[name='email']");
  const password = document.querySelector("[name='password']");
  const confirmPassword = document.querySelector("[name='confirm-password']");
  const phoneField = document.querySelector("[name='phone']");
  const locationField = document.querySelector("[name='location']");

  const nameId = document.getElementById("name");
  const emailId = document.getElementById("email");
  const fPasswordId = document.getElementById("pass0");
  const passwordId = document.getElementById("pass");
  const phoneId = document.getElementById("phone");
  const locationId = document.getElementById("loc");

  const nameError = document.createElement("p");
  const emailError = document.createElement("p");
  const phoneError = document.createElement("p");
  const locationError = document.createElement("p");
  const passwordError = document.createElement("p");

  [nameError, emailError, phoneError, locationError, passwordError].forEach(
    (error) => {
      error.classList.add("error-message");
    }
  );

  nameId.insertAdjacentElement("afterend", nameError);
  emailId.insertAdjacentElement("afterend", emailError);
  phoneId.insertAdjacentElement("afterend", phoneError);
  locationId.insertAdjacentElement("afterend", locationError);
  passwordId.insertAdjacentElement("afterend", passwordError);

  function validateName() {
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(nameField.value.trim())) {
      nameError.textContent = "Name should contain only letters and spaces.";
      nameId.style.borderBottom = "2px solid red";
      return false;
    }
    nameError.textContent = "";
    nameId.style.borderBottom = "2px solid #fff";
    return true;
  }

  function validateEmail() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailField.value.trim())) {
      emailError.textContent = "Enter a valid email address.";
      emailId.style.borderBottom = "2px solid red";
      return false;
    }
    emailError.textContent = "";
    emailId.style.borderBottom = "2px solid #fff";
    return true;
  }

  function validatePhone() {
    const phoneRegex = /^[0-9]{8,15}$/;
    if (!phoneRegex.test(phoneField.value.trim())) {
      phoneError.textContent =
        "Phone should contain only numbers (8-15 digits).";
      phoneId.style.borderBottom = "2px solid red";
      return false;
    }
    phoneError.textContent = "";
    phoneId.style.borderBottom = "2px solid #fff";
    return true;
  }

  function validateLocation() {
    if (locationField.value.trim() === "") {
      locationError.textContent = "Location cannot be empty.";
      locationId.style.borderBottom = "2px solid red";
      return false;
    }
    locationError.textContent = "";
    locationId.style.borderBottom = "2px solid #fff";
    return true;
  }

  function validatePassword() {
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if (!passwordRegex.test(password.value)) {
      passwordError.textContent = "Enter a valid password";
      fPasswordId.style.borderBottom = "2px solid red";
      passwordId.style.borderBottom = "2px solid red";
      return false;
    }
    passwordError.textContent = "";
    fPasswordId.style.borderBottom = "2px solid #fff";
    passwordId.style.borderBottom = "2px solid #fff";
    return true;
  }

  function validatePasswordsMatch() {
    if (password.value !== confirmPassword.value) {
      passwordError.textContent = "Passwords do not match!";
      fPasswordId.style.borderBottom = "2px solid red";
      passwordId.style.borderBottom = "2px solid red";
      return false;
    }
    passwordError.textContent = "";
    fPasswordId.style.borderBottom = "2px solid #fff";
    passwordId.style.borderBottom = "2px solid #fff";
    return true;
  }

  nameField.addEventListener("input", validateName);
  emailField.addEventListener("input", validateEmail);
  phoneField.addEventListener("input", validatePhone);
  locationField.addEventListener("input", validateLocation);
  password.addEventListener("input", validatePassword);
  confirmPassword.addEventListener("input", validatePasswordsMatch);

  form.addEventListener("submit", function (event) {
    if (
      !validateName() ||
      !validateEmail() ||
      !validatePassword() ||
      !validatePasswordsMatch() ||
      !validatePhone() ||
      !validateLocation()
    ) {
      event.preventDefault();
    }
  });
});
