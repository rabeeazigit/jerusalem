$(() => {
    $(".event_gallery_container").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: true,
        arrows: true,
        dots: true,
        infinite: false,
    });

    $(".wpcf7-spinner").html(`
        <div class="spinner-border spinner-border-sq-primary text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    `);
});
