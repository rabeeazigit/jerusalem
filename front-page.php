<?php get_header(); ?>

<div class="container-fluid px-0 home_header_wrapper">
    <?php get_template_part("template-parts/navbar"); ?>

    <?php
    $main_title = get_field("main_title") ?? null;
    $sub_title = get_field("sub_title") ?? null;
    ?>

    <div class="vstack my-3 px-5">
        <?php if ($main_title) : ?>
            <div class="display-4 fw-semibold">
                <?= $main_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($sub_title) : ?>
            <div class="display-4 fw-bold home_sbutitle">
                <?= $sub_title; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php get_template_part("template-parts/carousel", null, [
        "carousel_items" => array_reverse(get_field("carousel_items") ?? [])
    ]); ?>

    <div>
        <!-- IMPLEMENT CAROUSEL NEWS SLIDE -->
    </div>
</div>

<div class="container-fluid my-5 px-0">
    <?php get_template_part("template-parts/main-topics", null, [
        "main_topics_title" => get_field("main_topics_options")["main_topics_title"] ?? null,
        "main_topics_main_topics" => get_field("main_topics_options")["main_topics"] ?? null
    ]); ?>
</div>

<div class="container-fluid my-5 px-5">
    <?php get_template_part("template-parts/information", null, [
        "information_options" => get_field("information_options") ?? null,
    ]); ?>
</div>

<div class="container-fluid pt-5 pb-3 my-5 project_slider_wrapper">
    <?php get_template_part("template-parts/project-slider", null, [
        "project_slider_title" => get_field("project_slider_title") ?? null,
        "project_slider_paragraph" => get_field("project_slider_paragraph") ?? null,
        "project_slider_link" => get_field("project_slider_link") ?? null,
        "project_slider_items" => get_field("project_slider_items") ?? null,
    ]); ?>
</div>

<div class="container-fluid pt-5 pb-3 my-5">
    <?php get_template_part("template-parts/events-courses-slider", null, [
        "events_courses_title" => get_field("events_courses_title") ?? null,
        "events_and_courses_paragraph" => get_field("events_and_courses_paragraph") ?? null,
        "events_and_courses_link" => get_field("events_and_courses_link") ?? null,
        "events_and_courses_items" => get_field("events_and_courses_items") ?? null,
    ]); ?>
</div>

<?php get_footer(); ?>