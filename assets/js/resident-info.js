$(function () {
    // Setting the starting side image
    const startingSideImage = $(".resident_accordion").first().data("image");
    $(".resident_side_image").attr("src", startingSideImage);

    // Setting the first tab
    $(".tab-pane").first().addClass("show active");

    // listening to resident_accordion hover events
    // changing side image according to it
    $(".resident_accordion").on("mouseover", function () {
        const newImage = $(this).data("image");
        const currentImage = $(".resident_side_image").attr("src");

        // if the new image is alread shown
        // or there is no new image
        // skip this listener
        if (newImage == currentImage || !newImage) {
            return;
        }

        $(".resident_side_image").fadeOut(function () {
            $(this).attr("src", newImage).fadeIn();
        });
    });

    // filtering file when downloadable_file_search changes
    $(".downloadable_file_search").on("input", function () {
        const value = $(this).val() ?? "";

        if (value.length <= 3) {
            $(".downloadable_file_item").parent().fadeIn();
            return;
        }

        $(".downloadable_file_item:visible").filter(function () {
            const searchQuery = $(this).data("search");

            if (!searchQuery.includes(value)) {
                $(this).parent().fadeOut();
            }
        });
    });
});
