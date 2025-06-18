document.addEventListener("DOMContentLoaded", function () {
  const roleCards = document.querySelectorAll(".role-card");
  const roleInput = document.getElementById("selected_role");
  const submitButton = document.querySelector(".btn-submit");

  roleCards.forEach((card) => {
    card.addEventListener("click", () => {
      // Remove selected class from all cards
      roleCards.forEach((c) => c.classList.remove("selected"));

      // Add selected class to clicked card
      card.classList.add("selected");

      // Update hidden input value
      roleInput.value = card.dataset.role;

      // Enable submit button
      submitButton.disabled = false;
    });
  });
});
