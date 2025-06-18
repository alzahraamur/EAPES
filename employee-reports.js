document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchReport");
  const employeeFilter = document.getElementById("employeeFilter");
  const statusFilter = document.getElementById("statusFilter");
  const reportCards = document.querySelectorAll(".report-card");

  function filterReports() {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedEmployee = employeeFilter.value;
    const selectedStatus = statusFilter.value.toLowerCase();

    reportCards.forEach((card) => {
      const title = card.querySelector("h3").textContent.toLowerCase();
      const employee = card.dataset.employee;
      const status = card.dataset.status.toLowerCase();

      const matchesSearch = title.includes(searchTerm);
      const matchesEmployee =
        !selectedEmployee || employee === selectedEmployee;
      const matchesStatus = !selectedStatus || status === selectedStatus;

      card.style.display =
        matchesSearch && matchesEmployee && matchesStatus ? "block" : "none";
    });
  }

  searchInput.addEventListener("input", filterReports);
  employeeFilter.addEventListener("change", filterReports);
  statusFilter.addEventListener("change", filterReports);
});

function viewReport(reportId) {
  window.location.href = `view-report.php?id=${reportId}`;
}

function editReport(reportId) {
  window.location.href = `edit-report.php?id=${reportId}`;
}
