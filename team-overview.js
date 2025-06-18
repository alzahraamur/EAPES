document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchMember");
  const memberCards = document.querySelectorAll(".member-card");

  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();

    memberCards.forEach((card) => {
      const memberName = card.querySelector("h3").textContent.toLowerCase();

      if (memberName.includes(searchTerm)) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});
