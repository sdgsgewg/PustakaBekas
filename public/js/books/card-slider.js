document.querySelectorAll(".carousel").forEach((carousel) => {
    const slider = carousel.querySelector(".carousel-inner");
    const prev = carousel.querySelector(".carousel-control-prev");
    const next = carousel.querySelector(".carousel-control-next");

    let scrollAmount = 0;
    let visibleCards = getVisibleCards();
    const cardWidth = carousel.querySelector(".carousel-item").offsetWidth + 20;

    function getVisibleCards() {
        const screenWidth = window.innerWidth;
        if (screenWidth >= 1024) {
            return 3;
        } else if (screenWidth >= 600) {
            return 2;
        } else {
            return 1;
        }
    }

    // Update visibleCards on window resize
    window.addEventListener("resize", () => {
        visibleCards = getVisibleCards();
        scrollAmount = 0; // Reset scroll amount
        slider.scroll({
            left: scrollAmount,
            behavior: "smooth",
        });
    });

    next.addEventListener("click", () => {
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        if (scrollAmount < maxScroll) {
            scrollAmount += cardWidth;
            if (scrollAmount > maxScroll) {
                scrollAmount = maxScroll;
            }
            slider.scroll({
                left: scrollAmount,
                behavior: "smooth",
            });
        }
    });

    // Previous button functionality
    prev.addEventListener("click", () => {
        if (scrollAmount > 0) {
            scrollAmount -= cardWidth;
            if (scrollAmount < 0) {
                scrollAmount = 0;
            }
            slider.scroll({
                left: scrollAmount,
                behavior: "smooth",
            });
        }
    });
});
