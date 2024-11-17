$(document).ready(function () {
    console.log("Old Category Slug: ", oldCategorySlug);
    console.log("Old Genre Slugs: ", oldGenreSlugs);

    if (oldCategorySlug) {
        $("#category").val(oldCategorySlug);
        loadGenresByCategory(oldCategorySlug);
    }

    function loadGenresByCategory(categorySlug) {
        if (categorySlug) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                url: routeGetGenresByCategory.replace(":slug", categorySlug),
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log("Data received from AJAX:", data);
                    $("#genre").empty(); // Clear existing genres

                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            // Check if the genre slug is in the old selected slugs
                            var isChecked =
                                oldGenreSlugs &&
                                oldGenreSlugs.includes(value.slug)
                                    ? "checked"
                                    : "";

                            var listItem =
                                '<li class="list-group-item">' +
                                '<input class="form-check-input me-1" type="checkbox" name="genre[]" value="' +
                                value.slug + // Use slug instead of ID
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
            $("#genre").empty(); // Clear genres if no category selected
        }
    }

    // Event listener for category change
    $("#category").change(function () {
        var categorySlug = $(this).val();
        loadGenresByCategory(categorySlug); // Reload genres when category changes
    });
});
