document.addEventListener("DOMContentLoaded", () => {
    const modal        = document.getElementById("reportModal");
    const modalContent = document.getElementById("reportContent");
    const closeBtn     = document.querySelector(".modal .close");

    /*---------------------------------
      ▸ دالّة عامة يمكن استدعاؤها بـ onclick="viewReport(…)"
    ----------------------------------*/
    window.viewReport = function (reportId) {
        console.log("reportId sent:", reportId);   // لمعرفة الـ ID في الـ Console
        fetch(`get_report_details.php?id=${reportId}`)
            .then(res => res.text())
            .then(html => {
                modalContent.innerHTML = html;
                modal.style.display = "block";
            })
            .catch(() => {
                modalContent.innerHTML = "<p style='color:red;'>⚠️ Error loading report details.</p>";
                modal.style.display = "block";
            });
    };

    /*---------------------------------
      ▸ التعامل مع الأزرار التي تستعمل data-id
    ----------------------------------*/
    document.querySelectorAll(".btn-view[data-id]").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-id");
            window.viewReport(id); // استدعاء الدالّة العامة
        });
    });

    /*---------------------------------
      ▸ إغلاق النافذة المنبثقة
    ----------------------------------*/
    closeBtn.onclick = () => (modal.style.display = "none");
    window.onclick   = e => { if (e.target === modal) modal.style.display = "none"; };
});
