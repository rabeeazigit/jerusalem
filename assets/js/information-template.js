$(function () {
    // Setting the starting side image
    const startingSideImage = $(".resident_accordion").first().data("image");
    $(".resident_side_image").attr("src", startingSideImage);

    // Setting the first tab
    $(".tab-pane").first().addClass("show active");
    
    // check if the request has any url params
    // open correct tab
    const url = new URL(window.location.href);
    const selectedTab = url.searchParams.get("dt");
    
    if (selectedTab) {
        $(`.df_tab_btn[data-term-id=${selectedTab}]`).trigger("click");
    }
    
    // intercept the tab switching event
    // set correct url params
    $(".df_tab_btn").on("shown.bs.tab", function () {
        const termId = $(this).data("term-id");

        url.searchParams.set("dt", termId);

        window.history.pushState({}, "", url);
    });

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

    $("#load-more-faq").on("click", function () {
        const $faqCount = $("#more-faq-count");
        const currentLength = parseInt($faqCount.html());
        const updatedCounter = Math.max(0, currentLength - 7);
        const $faqsToShow = $(".faq-wrapper:hidden").slice(0, 7);

        $faqsToShow.fadeIn();

        $faqCount.html(updatedCounter);
        
        if (updatedCounter <= 0) {
            $(this).hide();
        }
    });
});
