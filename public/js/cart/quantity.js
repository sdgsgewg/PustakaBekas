document.addEventListener("DOMContentLoaded", function () {
    function updateQuantity(bookId, newQuantity) {
        fetch(`${qtyURL}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ book_id: bookId, quantity: newQuantity }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const quantityElement = document.querySelector(
                        `.qty[data-book-id="${bookId}"]`
                    );

                    quantityElement.textContent = newQuantity;

                    quantityElement.setAttribute("data-qty", newQuantity);
                } else {
                    alert("Failed to update the quantity. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error updating quantity:", error);
                alert("An error occurred. Please try again.");
            });
    }

    const decrementButtons = document.querySelectorAll(".btn-decrement");
    decrementButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const bookId = this.closest(".cartItem")
                .querySelector(".qty")
                .getAttribute("data-book-id");
            const currentQuantity = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-qty")
            );

            if (currentQuantity > 1) {
                updateQuantity(bookId, currentQuantity - 1);
            } else {
                const modal = new bootstrap.Modal(
                    document.getElementById(`removeModal-${bookId}`)
                );
                modal.show();
            }
        });
    });

    const incrementButtons = document.querySelectorAll(".btn-increment");
    incrementButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const bookId = this.closest(".cartItem")
                .querySelector(".qty")
                .getAttribute("data-book-id");
            const currentQuantity = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-qty")
            );
            const bookStock = parseInt(
                this.closest(".cartItem")
                    .querySelector(".qty")
                    .getAttribute("data-book-stock")
            );

            if (currentQuantity < bookStock) {
                updateQuantity(bookId, currentQuantity + 1);
            } else {
                const modal = new bootstrap.Modal(
                    document.getElementById(`maxQtyModal-${bookId}`)
                );
                modal.show();
            }
        });
    });
});
