<?php
$carousel_items = $args["carousel_items"] ?? [];
?>

<div class="vstack">
    <div class="carousel-controls mb-3 px-5">
        <div class="hstack gap-4 justify-content-end">
            <div class="carousel_play"></div>
            <div class="carousel_prev"></div>
            <div class="carousel_next"></div>
        </div>
    </div>

    <div class="carousel_wrapper">
        <?php foreach ($carousel_items as $e) : ?>
            <?php
            $media_type = $e["media_type"] ?? null;
            $video = $e["video"] ?? null;
            $image = $e["image"] ?? null;
            $title = $e["title"] ?? null;
            $paragraph = $e["paragraph"] ?? null;
            $link = $e["link"] ?? null;
            ?>

            <div class="row d-flex ps-5">
                <div class="col-md-9">
                    <div class="carousel_media_container overflow-hidden">
                        <?php if ($media_type == "video") : ?>
                            <video class="img-fluid object-fit-cover" src="<?= $video; ?>" autoplay muted loop></video>
                        <?php elseif ($media_type == "image") : ?>
                            <img class="img-fluid object-fit-cover" src="<?= $image; ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3" style="margin-right: -153px;">
                    <div class="vstack h-100 justify-content-end">
                        <div class="rounded-4 p-3 carousel_info_card">
                            <div class="vstack h-100 align-items-start">
                                <div class="flex-fill">
                                    <?php if ($title) : ?>
                                        <div class="fs-5 fw-bold mb-2">
                                            <?= $title; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($paragraph) : ?>
                                        <div class="fs-6">
                                            <?= $paragraph; ?>
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
            autoplaySpeed: 2000,
            slidesToShow: 1.3,
            slidesToScroll: 1,
            infinite: false,
            arrows: true,
            swipe: false,
            dots: false,
            rtl: true,
            prevArrow: $(".carousel_prev"),
            nextArrow: $(".carousel_next"),
        })
    })
</script>