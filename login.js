document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const togglePassword = document.querySelector(".toggle-password");

  // Password visibility toggle
  togglePassword.addEventListener("click", function () {
    const type =
      passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    this.querySelector("i").classList.toggle("bx-show");
    this.querySelector("i").classList.toggle("bx-hide");
  });

  // Form validation
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    // Remove any existing error messages
    removeErrorMessages();

    let isValid = true;

    // Username validation
    if (usernameInput.value.trim() === "") {
      showError(usernameInput, "Username is required");
      isValid = false;
    } else if (usernameInput.value.length < 3) {
      showError(usernameInput, "Username must be at least 3 characters");
      isValid = false;
    }

    // Password validation
    if (passwordInput.value === "") {
      showError(passwordInput, "Password is required");
      isValid = false;
    } else if (passwordInput.value.length < 6) {
      showError(passwordInput, "Password must be at least 6 characters");
      isValid = false;
    }

    if (isValid) {
      this.submit();
    }
  });

  function showError(input, message) {
    const inputBox = input.closest(".input-box");
    const errorMessage = document.createElement("span");
    errorMessage.className = "error-message";
    errorMessage.textContent = message;
    inputBox.appendChild(errorMessage);
    inputBox.classList.add("error");
  }

  function removeErrorMessages() {
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((error) => error.remove());

    const errorInputs = document.querySelectorAll(".input-box.error");
    errorInputs.forEach((input) => input.classList.remove("error"));
  }

  // Real-time validation
  usernameInput.addEventListener("input", function () {
    removeErrorMessages();
  });

  passwordInput.addEventListener("input", function () {
    removeErrorMessages();
  });
});
