<?php
$carousel_items = $args["carousel_items"] ?? [];
$dark_mode = $args["dark_mode"] ?? false;
?>

<?php if ($dark_mode) : ?>
    <style>
        .carousel_play {
            background-image: url(<?= get_template_directory_uri() . "/assets/images/pause-light.png"; ?>) !important;

        }

        .carousel_play.carousel_paused {
            background-image: url(<?= get_template_directory_uri() . "/assets/images/play-light.png"; ?>) !important;

        }

        .carousel_prev {
            background-image: url(<?= get_template_directory_uri() . "/assets/images/carousel_arrow_light.png "; ?>) !important;

        }

        .carousel_next {
            background-image: url(<?= get_template_directory_uri() . "/assets/images/carousel_arrow_light.png"; ?>) !important;

        }
    </style>
<?php endif; ?>

<div class="vstack">
    <div class="carousel-controls my-3 px-5">
        <div class="hstack gap-4 justify-content-end">
            <div class="carousel_play"></div>
            <div class="carousel_prev"></div>
            <div class="carousel_next"></div>
        </div>
    </div>

    <div class="carousel_wrapper py-5">
        <?php foreach ($carousel_items as $e) : ?>
            <?php
            $media_type = $e["media_type"] ?? null;
            $video = $e["video"] ?? null;
            $image = $e["image"] ?? null;
            $title = $e["title"] ?? null;
            $paragraph = $e["paragraph"] ?? null;
            $link = $e["link"] ?? null;
            ?>

            <div class="row d-flex ps-md-5 carousel_row_wrapper">
                <div class="col-md-10">
                    <div class="carousel_media_container overflow-hidden">
                        <?php if ($media_type == "video") : ?>
                            <div class="img-fluid object-fit-cover w-100">
                                <?= $video; ?>
                            </div>
                        <?php elseif ($media_type == "image") : ?>
                            <img class="img-fluid object-fit-cover w-100" src="<?= $image; ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col carousel_weird_card_thing <?= $dark_mode ? "text-dark" : ""; ?>">
                    <div class="vstack h-100 justify-content-end">
                        <div class="rounded-4 p-3 carousel_info_card">
                            <div class="vstack justify-content-between h-100 align-items-start">
                                <div class="vstack">
                                    <?php if ($title) : ?>
                                        <div class="fs-5 fw-bold mb-0 mb-md-2">
                                            <?= $title; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($paragraph) : ?>
                                        <div class="d-none d-md-block">
                                            <div class="fs-6 rubik limit-8-lines">
                                                <?= $paragraph; ?>
                                            </div>
                                        </div>

                                        <div class="d-block d-md-none">
                                            <div class="fs-6 rubik limit-3-lines">
                                                <?= $paragraph; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($link) : ?>
                                    <a href="<?= $link["url"]; ?>" target="<?= $link["target"]; ?>" class="text-decoration-none sq-primary-button">
                                        <?= $link["title"]; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $(function() {
        $(".carousel_play").on("click", function() {
            const isPaused = $(this).hasClass("carousel_paused")

            if (isPaused) {
                $(".carousel_wrapper").slick('slickPlay');
            } else {
                $(".carousel_wrapper").slick('slickPause');
            }

            $(this).toggleClass("carousel_paused");
        });

        $(".carousel_wrapper").slick({
            autoplay: true,
            autoplaySpeed: 6000,
            slidesToShow: 1.3,
            slidesToScroll: 1,
            infinite: false,
            arrows: true,
            swipe: false,
            dots: false,
            rtl: true,
            prevArrow: $(".carousel_prev"),
            nextArrow: $(".carousel_next"),
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    swipe: true,
                    centerMode: true,
                    centerPadding: "0px"
                }
            }]
        });
    })
</script>