<?php get_header(); ?>

<div class="container-fluid px-0 pb-5 home_header_wrapper">
    <?php get_template_part("template-parts/navbar"); ?>

    <?php
    $main_title = get_field("main_title") ?? null;
    $sub_title = get_field("sub_title") ?? null;
    ?>

    <div class="vstack my-3 pt-5 px-md-5 px-3">
        <?php if ($main_title) : ?>
            <div class="display-4 fw-normal rubik">
                <?= $main_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($sub_title) : ?>
            <div class="display-4 fw-bold home_sbutitle rubik">
                <?= $sub_title; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php get_template_part("template-parts/carousel", null, [
        "carousel_items" => get_field("carousel_items") ?? []
    ]); ?>

    <?php
    $news_slider = get_field("news_slider");
    ?>

    <?php if ($news_slider && is_array($news_slider) && !empty($news_slider)) : ?>
        <div class="carousel_news_sliders mt-4 hstack align-items-center justify-content-start overflow-hidden">
            <?php foreach ($news_slider as $e) : ?>
                <?php if (isset($e["news"]) && !empty($e["news"])) : ?>
                    <div>
                        <div class="w-100 hstack gap-1 px-4 align-items-start justify-content-center carousel_news_item">
                            <div class="fs-5"><?= $e["news"]; ?></div>
                            <img src="<?= get_template_directory_uri() . "/assets/images/btn-arrow-black.png"; ?>">
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    $(".carousel_news_sliders").slick({
        slidesToShow: 3.6,
        autoplay: true,
        autoplaySpeed: 0,
        swipe: false,
        focusOnSelect: false,
        speed: 5000,
        rtl: true,
        dots: false,
        arrows: false,
        cssEase: "linear",
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }]
    });
</script>

<div class="container-fluid px-0">
    <?php get_template_part("template-parts/main-topics", null, [
        "main_topics_title" => get_field("main_topics_options")["main_topics_title"] ?? null,
        "main_topics_main_topics" => get_field("main_topics_options")["main_topics"] ?? null
    ]); ?>
</div>

<div class="container-fluid my-5 px-0">
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

<div class="container-fluid px-md-5 px-3 py-5 mt-5 article_list_wrapper">
    <?php get_template_part("template-parts/article-list", null, [
        "article_list_options" => get_field("article_list_options") ?? null
    ]); ?>
</div>

<div class="container-fluid px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</div>

<?php get_footer(); ?>