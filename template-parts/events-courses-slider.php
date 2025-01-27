<?php
$events_courses_title = $args["events_courses_title"] ?? null;
$events_and_courses_paragraph = $args["events_and_courses_paragraph"] ?? null;
$events_and_courses_link = $args["events_and_courses_link"] ?? null;
$events_and_courses_items = $args["events_and_courses_items"] ?? [];
?>

<div class="row">
    <div class="col-md-3">
        <div class="vstack h-100 justify-content-between align-items-start pt-0 p-4">
            <div class="vstack align-items-start">
                <?php if ($events_courses_title) : ?>
                    <div class="fs-1 fw-bold mb-3">
                        <?= $events_courses_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($events_and_courses_paragraph) : ?>
                    <div class="fs-6 mb-3">
                        <?= $events_and_courses_paragraph; ?>
                    </div>
                <?php endif; ?>

                <?php if ($events_and_courses_link) : ?>
                    <a href="<?= $events_and_courses_link["url"]; ?>" target="<?= $events_and_courses_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                        <?= $events_and_courses_link["title"]; ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="vstack gap-1">
                <div class="event_slider_dots"></div>

                <div class="hstack gap-3">
                    <img src="<?= get_template_directory_uri() . "/assets/images/carousel_arrow.png"; ?>" class="event_slider_control event_slider_prev">
                    <img src="<?= get_template_directory_uri() . "/assets/images/carousel_arrow.png"; ?>" class="event_slider_control event_slider_next">
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div>
            <?php if (is_array($events_and_courses_items)) : ?>
                <div class="event-slider">
                    <?php foreach ($events_and_courses_items as $e) : ?>
                        <?php get_template_part("template-parts/event-card", null, [
                            "event_name" => $e->post_title,
                            "event_occurrence_date" => get_field("event_occurrence_date", $e),
                            "event_place" => get_field("event_place", $e),
                            "event_card_image" => get_field("event_card_image", $e),
                            "event_card_short_description" => get_field("event_card_short_description", $e),
                            "event_card_short_button_text" => get_field("event_card_short_button_text", $e),
                            "permalink" => get_permalink($e),
                            "post_type" => get_post_type($e)
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(".event-slider").slick({
            slidesToShow: 2.8,
            slidesToScroll: 1,
            infinite: false,
            arrows: true,
            swipe: false,
            dots: true,
            rtl: true,
            appendDots: $(".event_slider_dots"),
            prevArrow: $(".event_slider_prev"),
            nextArrow: $(".event_slider_next"),
        });
    });
</script>