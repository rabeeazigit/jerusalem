$(() => {
    $(".rr_wrapper_collapse").on("click", function () {
        const slider = $(this).find(".rr_element_collapse .youtube_rs_slider");
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
