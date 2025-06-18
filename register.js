document.addEventListener("DOMContentLoaded", function () {
  const registerForm = document.getElementById("registerForm");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirm_password");
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
  registerForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    // Submit form if validation passes
    this.submit();
  });

  function validateForm() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // Password validation
    if (password.length < 8) {
      showToast("Password must be at least 8 characters long", "error");
      return false;
    }

    if (!/[A-Z]/.test(password)) {
      showToast("Password must contain at least one uppercase letter", "error");
      return false;
    }

    if (!/[a-z]/.test(password)) {
      showToast("Password must contain at least one lowercase letter", "error");
      return false;
    }

    if (!/[0-9]/.test(password)) {
      showToast("Password must contain at least one number", "error");
      return false;
    }

    if (password !== confirmPassword) {
      showToast("Passwords do not match", "error");
      return false;
    }

    return true;
  }

  function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.innerHTML = `
            <div class="toast-content">
                <i class='bx ${type === "success" ? "bx-check" : "bx-x"}'></i>
                <span>${message}</span>
            </div>
        `;

    document.body.appendChild(toast);

    // Show toast
    setTimeout(() => toast.classList.add("show"), 100);

    // Hide and remove toast
    setTimeout(() => {
      toast.classList.remove("show");
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }
});
