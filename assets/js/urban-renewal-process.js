$(() => {
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
});
