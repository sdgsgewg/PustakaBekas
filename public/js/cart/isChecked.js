document.addEventListener("DOMContentLoaded", function () {
    function updateIsChecked(bookId, isChecked) {
        fetch(`${checkURL}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ book_id: bookId, is_checked: isChecked }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success) {
                    alert("Failed to update the cart item. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error updating isChecked:", error);
                alert("An error occurred. Please try again.");
            });
    }

    function updateSellerCheckbox(sellerId) {
        const sellerCheckbox = document.querySelector(
            `.check-seller[data-seller-id="${sellerId}"]`
        );
        const bookCheckboxes = document.querySelectorAll(
            `.check-book[data-seller-id="${sellerId}"]`
        );

        const allChecked = Array.from(bookCheckboxes).every(
            (checkbox) => checkbox.checked
        );
        sellerCheckbox.checked = allChecked;
        sellerCheckbox.indeterminate =
            !allChecked &&
            Array.from(bookCheckboxes).some((checkbox) => checkbox.checked);
    }

    function updateBookCheckboxes(sellerId) {
        const sellerCheckbox = document.querySelector(
            `.check-seller[data-seller-id="${sellerId}"]`
        );
        const bookCheckboxes = document.querySelectorAll(
            `.check-book[data-seller-id="${sellerId}"]`
        );

        const isChecked = sellerCheckbox.checked;
        Array.from(bookCheckboxes).forEach((checkbox) => {
            checkbox.checked = isChecked;
            const bookId = checkbox.getAttribute("data-book-id");
            updateIsChecked(bookId, isChecked);
        });
    }

    const bookCheckboxes = document.querySelectorAll(".check-book");
    bookCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("click", function () {
            const sellerId = this.getAttribute("data-seller-id");
            const bookId = this.getAttribute("data-book-id");
            updateSellerCheckbox(sellerId);
            updateIsChecked(bookId, this.checked);
        });
    });

    const sellerCheckboxes = document.querySelectorAll(".check-seller");
    sellerCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            const sellerId = this.getAttribute("data-seller-id");
            updateBookCheckboxes(sellerId);
        });
    });

    const sellerIds = [
        ...new Set(
            Array.from(bookCheckboxes).map((checkbox) =>
                checkbox.getAttribute("data-seller-id")
            )
        ),
    ];
    sellerIds.forEach((sellerId) => {
        updateSellerCheckbox(sellerId);
    });
});
