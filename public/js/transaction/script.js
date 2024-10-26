document.addEventListener("DOMContentLoaded", function () {
    const statusLinks = document.querySelectorAll(".nav-underline .nav-link");
    const transactionCards = document.querySelectorAll(".transaction-card");
    const contentHaveOrder = document.getElementById("haveOrder");
    const contentNoOrder = document.getElementById("noOrder");

    function displayContent(selectedStatus) {
        let hasOrder = false;

        transactionCards.forEach((card) => {
            if (card.getAttribute("data-status") === selectedStatus) {
                card.style.display = "block";
                hasOrder = true;
            } else {
                card.style.display = "none";
            }
        });

        if (hasOrder) {
            contentHaveOrder.style.display = "block";
            contentNoOrder.style.display = "none";
        } else {
            contentHaveOrder.style.display = "none";
            contentNoOrder.style.display = "block";
        }
    }

    // Initial display with "Pending" as default
    statusLinks.forEach((navLink) => {
        const selectedStatus = navLink.getAttribute("data-status");

        if (selectedStatus === "Pending") {
            navLink.classList.add("active");
            displayContent(selectedStatus);
        }
    });

    // Event listener for each nav-link
    statusLinks.forEach((navLink) => {
        navLink.addEventListener("click", function (e) {
            e.preventDefault();

            statusLinks.forEach((link) => link.classList.remove("active"));
            this.classList.add("active");

            const selectedStatus = this.getAttribute("data-status");
            displayContent(selectedStatus);
        });
    });
});
