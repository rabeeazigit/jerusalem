<?php
$title = $args["title"] ?? null;
$youtube_ids = $args["youtube_ids"] ?? null;
$slider_id = wp_unique_id("youtube_slider");
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

            <iframe
                class="rounded-4"
                style="width: 100%; height: 68dvh"
                src="https://www.youtube.com/embed/<?= $youtube_id["video_id"]; ?>"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen></iframe>
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
    }

    .youtube_rs_slider .slick-prev {
        z-index: 99;
        right: 52px;
        position: absolute;
        scale: 3;
        top: 362px;
    }
</style>

<script>
    $(function() {
        $("#<?= $slider_id; ?>").slick({
            rtl: true,
            arrows: true,
            slidesToShow: 1,
            slidesToScroll: 1
        })
    });
</script>