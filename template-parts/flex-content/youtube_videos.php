<?php
$title = $args["title"] ?? null;
$youtube_ids = $args["youtube_ids"] ?? null;
$slider_id = uniqid() . "_youtube_slider_" . uniqid();
?>

<?php if ($title) : ?>
    <div class="fs-5 fw-bold mb-3">
        <?= $title; ?>
    </div>
<?php endif; ?>

<?php if ($youtube_ids && is_array($youtube_ids) && !empty($youtube_ids)) : ?>
    <div class="vstack">
        <?php if (count($youtube_ids) > 1) : ?>
            <div class="hstack justify-content-end gap-3">
                <?php if (wp_is_mobile()) : ?>
                    <img src="<?= get_template_directory_uri() . "/assets/images/video/right_arrow.png"; ?>" id="<?= "next_" . $slider_id; ?>" class="rs_mb_arrow rs_mb_next" alt="">
                    <img src="<?= get_template_directory_uri() . "/assets/images/video/left_arrow.png"; ?>" id="<?= "prev_" . $slider_id; ?>" class="rs_mb_arrow rs_mb_prev" alt="">
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="youtube_rs_slider" id="<?= $slider_id; ?>">
            <?php foreach ($youtube_ids as $youtube_id) : ?>
                <?php if (!isset($youtube_id["video_id"]) || !$youtube_id["video_id"]) continue; ?>

                <?php if (wp_is_mobile()) : ?>
                    <iframe
                        class="rounded-4 youtube_video_rs"
                        style="width: 100%; height: 200px"
                        src="https://www.youtube.com/embed/<?= $youtube_id["video_id"]; ?>"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                <?php else : ?>
                    <iframe
                        class="rounded-4"
                        style="width: 100%; height: 68dvh"
                        src="https://www.youtube.com/embed/<?= $youtube_id["video_id"]; ?>"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<style>
    .rs_mb_arrow {
        width: 38px;
        height: 38px;
        object-fit: cover;
        object-position: center;
    }

    .rs_mb_next {
        top: 45%;
        right: 2%;
    }

    .rs_mb_prev {
        top: 45%;
        left: 2%;
    }

    .youtube_video_rs {
        height: 540px;

        @media screen and (width <=768px) {
            height: 240px;
        }
    }

    .youtube_rs_slider {
        position: relative !important;
    }

    .youtube_rs_slider .slick-next {
        left: 52px !important;
        position: absolute !important;
        scale: 3 !important;
        top: 362px !important;

        @media screen and (width <=768px) {
            top: 135px !important;
            left: 8px !important;
        }
    }

    .youtube_rs_slider .slick-next::before {
        content: "";
        background-image: url(<?= get_template_directory_uri() . "/assets/images/video/left_arrow.png"; ?>);
        display: block;
        width: 15px !important;
        height: 15px !important;
        border-radius: 100% !important;
        background-size: contain;
    }

    .youtube_rs_slider .slick-prev::before {
        content: "";
        background-image: url(<?= get_template_directory_uri() . "/assets/images/video/right_arrow.png"; ?>);
        display: block;
        width: 15px !important;
        height: 15px !important;
        border-radius: 100%;
        background-size: contain;
    }

    .youtube_rs_slider .slick-prev {
        z-index: 99;
        right: 52px !important;
        position: absolute;
        scale: 3;
        top: 362px !important;

        @media screen and (width <=768px) {
            top: 135px !important;
            right: 24px !important;
        }
    }

    .youtube_rs_slider .slick-dots {
        bottom: 24px !important;
    }

    .youtube_rs_slider .slick-dots button:before {
        color: white !important;
        font-size: 1rem;
        opacity: 0.6;
        transition: all 250ms ease-in-out;
    }

    .youtube_rs_slider .slick-dots li.slick-active button:before {
        font-size: 1.4rem;
    }
</style>