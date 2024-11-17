document.addEventListener("DOMContentLoaded", function () {
    const statusLinks = document.querySelectorAll(".nav-underline .nav-link");
    const transactionCards = document.querySelectorAll(".transaction-card");
    const contentHaveOrder = document.getElementById("haveOrder");
    const contentNoOrder = document.getElementById("noOrder");

    // Function to display content based on selected status
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

        // Toggle content based on whether orders exist for selected status
        if (hasOrder) {
            contentHaveOrder.style.display = "block";
            contentNoOrder.style.display = "none";
        } else {
            contentHaveOrder.style.display = "none";
            contentNoOrder.style.display = "block";
        }
    }

    // Set initial active link and display filtered content based on it
    function initialize() {
        let activeLink = document.querySelector(".nav-underline .nav-link.active");
        if (!activeLink) {
            // If no link is active, set "Pending" as default
            activeLink = document.querySelector('.nav-underline .nav-link[data-status="Pending"]');
            activeLink.classList.add("active");
        }
        // Display content for the current active link's status
        displayContent(activeLink.getAttribute("data-status"));
    }

    initialize(); // Run initialize on DOMContentLoaded to set initial state

    // Event listener for each nav-link
    statusLinks.forEach((navLink) => {
        navLink.addEventListener("click", function (e) {
            e.preventDefault();

            // Update active state on links
            statusLinks.forEach((link) => link.classList.remove("active"));
            this.classList.add("active");

            // Display content based on the clicked status
            const selectedStatus = this.getAttribute("data-status");
            displayContent(selectedStatus);
        });
    });
});
