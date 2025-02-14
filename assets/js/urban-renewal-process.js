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
});
