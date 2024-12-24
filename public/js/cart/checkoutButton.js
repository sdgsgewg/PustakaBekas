document.addEventListener("DOMContentLoaded", function () {
    const checkoutButton = document.getElementById("checkout-button");
    const bookCheckboxes = document.querySelectorAll(".check-book");
    const sellerCheckboxes = document.querySelectorAll(".check-seller");
    const modalMsg = document.getElementById("cartModalMessage");

    function updateModalMessage(isCheckedTotal) {
        const message =
            isCheckedTotal > 0
                ? "Please select books from only one seller to proceed with checkout."
                : "No books selected. Please choose at least one book to continue.";

        modalMsg.textContent = message;
    }

    function updateCheckoutButton() {
        const checkoutURL = checkoutButton.getAttribute("data-checkout-url");

        let checkBookAmount = [];
        let valid = false;

        sellerCheckboxes.forEach((sellerCheckbox) => {
            const sellerId = sellerCheckbox.getAttribute("data-seller-id");
            const bookCheckboxesPerSeller = document.querySelectorAll(
                `.check-book[data-seller-id="${sellerId}"]`
            );
            let checkBook = 0;
            bookCheckboxesPerSeller.forEach((bookCheckbox) => {
                if (bookCheckbox.checked) {
                    checkBook++;
                }
            });
            checkBookAmount.push(checkBook);
        });

        let count = 0,
            isCheckedTotal = 0;

        for (let i = 0; i < checkBookAmount.length; i++) {
            isCheckedTotal += checkBookAmount[i];
            if (checkBookAmount[i] > 0) {
                count++;
            }
        }

        if (count == 1) {
            valid = true;
        }

        if (valid) {
            checkoutButton.setAttribute("href", checkoutURL);
            updateModalMessage(isCheckedTotal);
        } else {
            checkoutButton.removeAttribute("href");
            updateModalMessage(isCheckedTotal);
        }

        checkoutButton.classList.toggle("btn-primary", valid);
        checkoutButton.classList.toggle("btn-secondary", !valid);
    }

    function handleCheckoutClick(event) {
        if (!checkoutButton.getAttribute("href")) {
            event.preventDefault(); // Prevent navigation
            const modal = new bootstrap.Modal(
                document.getElementById(`cartModal`)
            );
            modal.show();
        }
    }

    bookCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateCheckoutButton);
    });

    sellerCheckboxes.forEach((sellerCheckbox) => {
        sellerCheckbox.addEventListener("change", updateCheckoutButton);
    });

    checkoutButton.addEventListener("click", handleCheckoutClick);
    updateCheckoutButton();
});
