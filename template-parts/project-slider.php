<?php
$project_slider_title = $args["project_slider_title"] ?? null;
$project_slider_paragraph = $args["project_slider_paragraph"] ?? null;
$project_slider_link = $args["project_slider_link"] ?? null;
$project_slider_items = $args["project_slider_items"] ?? null;
?>

<div class="row">
    <div class="col-md-3">
        <div class="vstack h-100 justify-content-between align-items-start pt-0 p-4">
            <div class="vstack align-items-start">
                <?php if ($project_slider_title) : ?>
                    <div class="fs-1 fw-bold mb-3">
                        <?= $project_slider_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($project_slider_paragraph) : ?>
                    <div class="fs-6 mb-3">
                        <?= $project_slider_paragraph; ?>
                    </div>
                <?php endif; ?>

                <?php if ($project_slider_link) : ?>
                    <a href="<?= $project_slider_link["url"]; ?>" target="<?= $project_slider_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                        <?= $project_slider_link["title"]; ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="vstack gap-1">
                <div class="project_slider_dots"></div>

                <div class="hstack gap-3">
                    <img src="<?= get_template_directory_uri() . "/assets/images/carousel_arrow.png"; ?>" class="project_slider_control project_slider_prev">
                    <img src="<?= get_template_directory_uri() . "/assets/images/carousel_arrow.png"; ?>" class="project_slider_control project_slider_next">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div>
            <div class="project-slider">
                <?php foreach ($project_slider_items as $e) : ?>
                    <?php get_template_part("template-parts/project-card", null, [
                        "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                        "project_status" => get_field("project_status", $e) ?? null,
                        "project_card_image" => get_field("project_card_image", $e) ?? null,
                        "project_name" => $e->post_title ?? null,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(".project-slider").slick({
            slidesToShow: 2.8,
            slidesToScroll: 1,
            infinite: false,
            arrows: true,
            swipe: false,
            dots: true,
            rtl: true,
            appendDots: $(".project_slider_dots"),
            prevArrow: $(".project_slider_prev"),
            nextArrow: $(".project_slider_next"),
        });
    });
</script>