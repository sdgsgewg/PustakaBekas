$(document).ready(function () {
    // Get genres from the book's category (edit)
    if (oldCategoryId) {
        loadGenresByCategory(oldCategoryId);
        $("#category").val(oldCategoryId);
    }

    function loadGenresByCategory(categoryId) {
        if (categoryId) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                url: routeGetGenresByCategory.replace(":id", categoryId),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log("Data received from AJAX:", data); // Log the received data
                    $("#genre").empty();
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            var isChecked = oldGenreId.includes(value.id)
                                ? "checked"
                                : "";

                            var listItem =
                                '<li class="list-group-item">' +
                                '<input class="form-check-input me-1" type="checkbox" name="genre_id[]" value="' +
                                value.id +
                                '" ' +
                                isChecked +
                                ' id="CheckboxStretched' +
                                key +
                                '">' +
                                '<label class="form-check-label stretched-link" for="CheckboxStretched' +
                                key +
                                '">' +
                                value.name +
                                "</label>" +
                                "</li>";
                            $("#genre").append(listItem);
                        });
                    } else {
                        $("#genre").append(
                            '<li class="list-group-item">No genres found for this category.</li>'
                        );
                    }
                },
                error: function (xhr) {
                    console.error(xhr);
                },
            });
        } else {
            $("#genre").empty();
        }
    }

    // Event listener for category change
    $("#category").change(function () {
        var categoryId = $(this).val();
        loadGenresByCategory(categoryId);
    });
});
