<?php
$title = $args["title"] ?? null;
$youtube_ids = $args["youtube_ids"] ?? null;
$slider_id = "youtube_slider_" . time();
?>

<?php if ($title) : ?>
    <div class="fs-5 fw-bold mb-3">
        <?= $title; ?>
    </div>
<?php endif; ?>

<?php if ($youtube_ids && is_array($youtube_ids) && !empty($youtube_ids)) : ?>
    <div class="youtube_rs_slider" id="<?= $slider_id; ?>">
        <?php foreach ($youtube_ids as $youtube_id) : ?>
            <?php if (!isset($youtube_id["video_id"]) || !$youtube_id["video_id"]) continue; ?>

            <?php if (wp_is_mobile()) : ?>
                <iframe
                    class="rounded-4"
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
<?php endif; ?>

<style>
    .youtube_rs_slider {
        position: relative;
    }

    .youtube_rs_slider .slick-next {
        left: 52px;
        position: absolute;
        scale: 3;
        top: 362px;

        @media screen and (width <=768px) {
            top: 135px;
            left: 8px;
        }
    }

    .youtube_rs_slider .slick-next::before {
        content: "";
        background-image: url(<?= get_template_directory_uri() . "/assets/images/video/left_arrow.png"; ?>);
        display: block;
        width: 15px;
        height: 15px;
        border-radius: 100%;
        background-size: contain;
    }

    .youtube_rs_slider .slick-prev::before {
        content: "";
        background-image: url(<?= get_template_directory_uri() . "/assets/images/video/right_arrow.png"; ?>);
        display: block;
        width: 15px;
        height: 15px;
        border-radius: 100%;
        background-size: contain;
    }

    .youtube_rs_slider .slick-prev {
        z-index: 99;
        right: 52px;
        position: absolute;
        scale: 3;
        top: 362px;

        @media screen and (width <=768px) {
            top: 135px;
            right: 24px;
        }
    }

    .youtube_rs_slider .slick-dots {
        bottom: 24px;
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