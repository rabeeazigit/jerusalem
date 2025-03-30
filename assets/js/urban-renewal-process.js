$(() => {
    // stop the sticky main menu in this page
    $("#main-sticky-navbar").removeClass("sticky-top");
    
    $(".uc_category_btn").on("click", function () {
        const ucCategory = $(this).data("uc-category");
        const target = $(
            `.urban_category_accordion_wrapper[data-process-category="${ucCategory}"]`
        );

        // if the target element is already shown
        // do nothing
        if (!target.hasClass("uc_hidden")) {
            return;
        }

        // hide all wrappers and add uc_hidden to them
        // remove uc_hidden from target and fade it in
        $(".urban_category_accordion_wrapper")
            .addClass("uc_hidden")
            .fadeOut(250);
        target.removeClass("uc_hidden").fadeIn(250);

        $(".stages_collapse_wrapper").collapse("hide");
        $(".stage_collapable").collapse("hide");
    });

    $(".stage_collapable").on("show.bs.collapse", function () {
        const slider = $(this).find(".youtube_rs_slider");
        const id = $(this).find(".youtube_rs_slider").attr("id");

        if (!slider.hasClass("slick-initialized")) {
            slider.slick({
                rtl: true,
                arrows: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                infinite: false,
                swipe: false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: true,
                            prevArrow: `#next_${id}`,
                            nextArrow: `#prev_${id}`,
                        },
                    },
                ],
            });
        }
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

    // listen for stage submenu clicks
    $(".renewal_stage_submenu").on("click", function () {
        // get the target, parent, collapse element ids
        const stageId = $(this).data("target");
        const stageParentId = $(this).data("parent-target");

        // if there's no target id exit
        if (!stageId || !stageParentId) {
            return;
        }
        
        // find the correct target element
        const $stageElement = $(`.stage_accordion[data-id=${stageId}][data-parent=${stageParentId}]`);
        const $collapseParent = $(`#${$stageElement.data("collapse-parent")}`);
        const $stageCollapseElement = $(`#${$stageElement.data("stage-collapse")}`);

        // open the stage collapse wrapper
        $collapseParent.collapse("show");
        
        // open the stage it self after opening the collapse
        // $stageCollapseElement.collapse("show");

        // get the position of the element relative to the document
        const stageElementTop = $stageElement.offset().top;

        // scroll to the opened element smoothly
        $("html, body").animate({ scrollTop: stageElementTop - 200 }, 500);

        console.log({
            stageId,
            stageParentId,
            $stageElement,
            $collapseParent,
            $stageCollapseElement,
            stageElementTop
        });
    });

    // listen for search field changes
    // $(".stages_search").on("input", function () {
    //     const query = $(this).val();

    //     if (query.length <= 3) {
    //         return;
    //     }

    //     console.log({
    //         query
    //     });
    // });
    $('.stages_search').on('input', function () {
        const query = $(this).val().toLowerCase().trim();
    
        if (query.length === 0) {
            // If input is cleared, show all items
            $('.urban_category_accordion_wrapper').show();
            $('.vstack').show();
            $('.stages_collapse_wrapper').collapse('hide');
            return;
        }
    
        if (query.length <= 2) {
            $('.urban_category_accordion_wrapper').show();
            $('.stages_collapse_wrapper').collapse('hide');
            return;
        }
    
        $('.urban_category_accordion_wrapper:not(.uc_hidden)').each(function () {
            const categoryWrapper = $(this);
            let found = false;
    
            categoryWrapper.find('.vstack').each(function () {
                const itemWrapper = $(this);
                const title = itemWrapper.find('.fs-2').text().toLowerCase();
                const description = itemWrapper.find('.fs-6').text().toLowerCase();
                let stageFound = false;
    
                // Check title and description
                if (title.includes(query) || description.includes(query)) {
                    found = true;
                    itemWrapper.show();
                    return;
                }
    
                // Check inside each stage accordion
                itemWrapper.find('.stage_accordion_wrapper').each(function () {
                    const stageWrapper = $(this);
                    const stageTitle = stageWrapper.find('.fs-5').text().toLowerCase();
                    const stageContent = stageWrapper.find('.stage_collapable').text().toLowerCase();
    
                    if (stageTitle.includes(query) || stageContent.includes(query)) {
                        stageFound = true;
                        found = true;
                        stageWrapper.find('.stage_accordion').removeClass('collapsed');
                        stageWrapper.find('.stage_collapable').collapse('show');
                        itemWrapper.show();
                        // Open parent item accordion as well
                        itemWrapper.closest('.stages_collapse_wrapper').collapse('show');
                    } else {
                        stageWrapper.find('.stage_accordion').addClass('collapsed');
                        stageWrapper.find('.stage_collapable').collapse('hide');
                    }
                });
    
                if (!stageFound) {
                    itemWrapper.hide();
                }
            });
    
            if (found) {
                categoryWrapper.show();
            } else {
                categoryWrapper.hide();
            }
        });
    });
    
});
