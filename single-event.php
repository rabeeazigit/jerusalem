<?php get_header(); ?>

<?php
$controller = new SingleEvent();
?>

<?php get_template_part("template-parts/navbar"); ?>

<header class="container-fluid px-md-5 px-3">
    <?php if (function_exists("yoast_breadcrumb")) : ?>
        <div class="sq_breadcrumbs pt-5 fs-5">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>
</header>

<main class="container-fluid px-md-5 px-3 pt-4">
    <div class="row row-gap-4">
        <div class="col-md-6">
            <div class="vstack mb-3">
                <?php if ($controller->hero_title) : ?>
                    <div class="display-4 fw-bold">
                        <?= $controller->hero_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($controller->hero_desc) : ?>
                    <div class="fs-5">
                        <?= $controller->hero_desc; ?>
                    </div>
                <?php endif; ?>

                <?php if (wp_is_mobile()) : ?>
                    <div class="col-md-5">
                        <?php if (!$controller->details_show_gallery) : ?>
                            <?php if ($controller->details_side_image) : ?>
                                <div class="d-flex justify-content-center sticky-top">
                                    <img class="single-event-side-image rounded-4 img-fluid object-fit-cover" src="<?= $controller->details_side_image; ?>">
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($controller->details_gallery) : ?>
                                <div class="event_gallery_container">
                                    <?php foreach ($controller->details_gallery as $e) : ?>
                                        <?php
                                        $type = $e["type"] ?? null;
                                        $image = $e["image"] ?? null;
                                        $youtube_video_id = $e["youtube_video_id"] ?? null;
                                        ?>
                                        <?php if ($type == "image" && $image) : ?>
                                            <img src="<?= $image; ?>" class=" single-event-side-image">
                                        <?php elseif ($type == "video" && $youtube_video_id) : ?>
                                            <?php if (wp_is_mobile()) : ?>
                                                <iframe
                                                    class="single-event-side-image rounded-4 youtube_video_rs"
                                                    src="https://www.youtube.com/embed/<?= $youtube_video_id; ?>"
                                                    title="YouTube video player"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    referrerpolicy="strict-origin-when-cross-origin"
                                                    allowfullscreen></iframe>
                                            <?php else : ?>
                                                <iframe
                                                    class="single-event-side-image rounded-4"
                                                    src="https://www.youtube.com/embed/<?= $youtube_video_id; ?>"
                                                    title="YouTube video player"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    referrerpolicy="strict-origin-when-cross-origin"
                                                    allowfullscreen></iframe>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php $flex_content = get_field("detailed_content"); ?>
            <?php if ($flex_content && is_array($flex_content)) : ?>
                <?php foreach ($flex_content as $e) : ?>
                    <?php
                    $fc_layout = $e["acf_fc_layout"];
                    $value = $e["value"];

                    if ($fc_layout && $value) {
                        get_template_part("template-parts/flex-content/{$fc_layout}", null, $value);
                    }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (in_array($controller->post_type, ["course", "event"])) : ?>
                <div class="vstack">
                    <div class="my-4 p-5 pt-4 rounded-4" style="background-color: #EBE8E3;">
                        <div class="mb-5">
                            <div class="display-6 fw-bold mb-0">
                                <?php if ($controller->post_type == "course") : ?>
                                    הרשמה לקורס
                                <?php elseif ($controller->post_type == "event") : ?>
                                    הרשמה לכנס
                                <?php endif; ?>
                            </div>

                            <div class="fs-5">
                                מלאו את הפרטים שלכם להרשמה.
                            </div>
                        </div>

                        <?php if ($controller->post_type == "course") : ?>
                            <?= do_shortcode('[contact-form-7 id="40c6b24" title="Course Form"]'); ?>
                        <?php elseif ($controller->post_type == "event") : ?>
                            <?= do_shortcode('[contact-form-7 id="a5ae09f" title="Event Form"]'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-1"></div>

        <?php if (!wp_is_mobile()) : ?>
            <div class="col-md-5">
                <?php if (!$controller->details_show_gallery) : ?>
                    <?php if ($controller->details_side_image) : ?>
                        <div class="d-flex justify-content-center sticky-top">
                            <img class="single-event-side-image rounded-4 img-fluid object-fit-cover" src="<?= $controller->details_side_image; ?>">
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($controller->details_gallery) : ?>
                        <div class="sticky-top">
                            <div class="event_gallery_container">
                                <?php foreach ($controller->details_gallery as $e) : ?>
                                    <?php
                                    $type = $e["type"] ?? null;
                                    $image = $e["image"] ?? null;
                                    $youtube_video_id = $e["youtube_video_id"] ?? null;
                                    ?>
                                    <?php if ($type == "image" && $image) : ?>
                                        <img src="<?= $image; ?>" class=" single-event-side-image">
                                    <?php elseif ($type == "video" && $youtube_video_id) : ?>
                                        <?php if (wp_is_mobile()) : ?>
                                            <iframe
                                                class="single-event-side-image rounded-4 youtube_video_rs"
                                                src="https://www.youtube.com/embed/<?= $youtube_video_id; ?>"
                                                title="YouTube video player"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                                allowfullscreen></iframe>
                                        <?php else : ?>
                                            <iframe
                                                class="single-event-side-image rounded-4"
                                                src="https://www.youtube.com/embed/<?= $youtube_video_id; ?>"
                                                title="YouTube video player"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin"
                                                allowfullscreen></iframe>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<section class="container-fluid my-4 px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>

<?php get_footer(); ?>