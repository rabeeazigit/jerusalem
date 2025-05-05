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

    const url = new URL(window.location.href);
    
    // check if the request has any url params
    // open correct tab
    const selectedTab = url.searchParams.get("t");
    
    if (selectedTab) {
        $(`.rights_trigger_btn[data-term-id=${selectedTab}]`).trigger("click");
    }
    
    // intercept the tab switching event
    // set correct url params
    $(".rights_trigger_btn").on("shown.bs.tab", function () {
        const termId = $(this).data("term-id");

        url.searchParams.set("t", termId);

        window.history.pushState({}, "", url);
    });
});
