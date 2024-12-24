const title = document.querySelector("#title");
const name = document.querySelector("#name");
const slug = document.querySelector("#slug");
const v = value;

// document.addEventListener("DOMContentLoaded", function () {
//     window.confirmDelete = function (bookId) {
//         console.log("Attempting to delete book with ID:", bookId);
//         const form = document.getElementById("deleteForm-" + bookId);
//         if (form) {
//             form.submit();
//         } else {
//             console.error("Form not found: deleteForm-" + bookId);
//         }
//     };
// });

if (v === "book") {
    title.addEventListener("change", function () {
        fetch(`/dashboard/${v}/checkSlug?title=${title.value}`)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
} else {
    name.addEventListener("change", function () {
        fetch(`/dashboard/${v}/checkSlug?name=${name.value}`)
            .then((response) => response.json())
            .then((data) => (slug.value = data.slug));
    });
}

document.addEventListener("trix-file-accept", function (e) {
    e.preventDefault();
});

function previewImage() {
    const image = document.querySelector("#image");
    const imgPreview = document.querySelector(".img-preview");

    imgPreview.style.display = "block";

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}
