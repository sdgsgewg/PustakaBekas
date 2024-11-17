document.addEventListener("DOMContentLoaded", function () {
    const statusLinks = document.querySelectorAll(".nav-underline .nav-link");
    const tradeCards = document.querySelectorAll(".trade-card");
    const contentHaveTrade = document.getElementById("haveTrade");
    const contentNoTrade = document.getElementById("noTrade");

    function displayContent(selectedStatus) {
        let hasTrade = false;

        tradeCards.forEach((card) => {
            if (card.getAttribute("data-status") === selectedStatus) {
                card.style.display = "block";
                hasTrade = true;
            } else {
                card.style.display = "none";
            }
        });

        if (hasTrade) {
            contentHaveTrade.style.display = "block";
            contentNoTrade.style.display = "none";
        } else {
            contentHaveTrade.style.display = "none";
            contentNoTrade.style.display = "block";
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
