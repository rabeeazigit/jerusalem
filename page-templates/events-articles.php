<?php

// Template Name: Events And Articles

get_header();
?>

<header class="container-fluid px-0 text-light">
    <div class="linear_bg_page py-5">
        <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>
        <?php
        $main_title = get_field("main_title") ?? null;
        $sub_title = get_field("sub_title") ?? null;
        ?>
        <div class="vstack my-3 pt-4 px-md-5 px-3">
            <?php if (function_exists("yoast_breadcrumb")) : ?>
                <div class="sq_breadcrumbs fs-5">
                    <?php yoast_breadcrumb(); ?>
                </div>
            <?php endif; ?>

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
            "carousel_items" => get_field("carousel_items") ?? [],
            "dark_mode" => true
        ]); ?>
    </div>
</header>

<section class="article_wrapper py-5">
    <main class="container-fluid events-container">
        <?php
        $posts_title = get_field("posts_title") ?? null;
        $limit = 12;
        $page = 1;
        $posts = get_posts([
            "post_type" => "event",
            "posts_per_page" => $limit,
            "paged" => $page,
        ]);
        $remaining = max(0, wp_count_posts("event")->publish - count($posts));
        ?>

        <?php if ($posts_title) : ?>
            <div class="display-4 fw-bold text-center mb-3">
                <?= $posts_title; ?>
            </div>
        <?php endif; ?>

        <?php if (wp_is_mobile()) : ?>
            <form id="search_form" class="row row-gap-3 mb-5 px-3">
                <div class="col-12">
                    <div class="input-group bg-white rounded-pill border overflow-hidden ">
                        <span class="input-group-text border-0" style="background-color: transparent;">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" id="query_search" class="form-control border-0" name="query" placeholder="חיפוש">
                    </div>
                </div>

                <div class="col-12 hstack gap-3 justify-content-center flex-wrap">
                    <div>
                        <input type="checkbox" class="btn-check event_filter_btn" name="event" id="event">
                        <label for="event" class="btn btn-outline-sq-primary rounded-pill">כנסים</label>
                    </div>

                    <div>
                        <input type="checkbox" class="btn-check event_filter_btn" name="course" id="course">
                        <label for="course" class="btn btn-outline-sq-primary rounded-pill">קורסים</label>
                    </div>

                    <div>
                        <input type="checkbox" class="btn-check event_filter_btn" name="done" id="done">
                        <label for="done" class="btn btn-outline-sq-primary rounded-pill">התקיימו</label>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <form id="search_form" class="hstack gap-4 align-items-center justify-content-center mb-5">
                <input type="checkbox" class="btn-check event_filter_btn" name="event" id="event">
                <label for="event" class="btn btn-outline-sq-primary rounded-pill">כנסים</label>

                <input type="checkbox" class="btn-check event_filter_btn" name="course" id="course">
                <label for="course" class="btn btn-outline-sq-primary rounded-pill">קורסים</label>

                <input type="checkbox" class="btn-check event_filter_btn" name="done" id="done">
                <label for="done" class="btn btn-outline-sq-primary rounded-pill">התקיימו</label>

                <div class="input-group bg-white rounded-pill border overflow-hidden event_searchbar">
                    <span class="input-group-text border-0" style="background-color: transparent;">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" id="query_search" class="form-control border-0" name="query" placeholder="חיפוש">
                </div>
            </form>
        <?php endif; ?>

        <?php if ($posts && is_array($posts) && !empty($posts)) : ?>
            <div class="row row-gap-4" id="events-container">
                <?php foreach ($posts as $e) : ?>
                    <div class="col-md-4 col-12">
                        <?php get_template_part("template-parts/event-card", null, [
                            "event_name" => $e->post_title,
                            "event_occurrence_date" => get_field("event_occurrence_date", $e),
                            "event_place" => get_field("event_place", $e),
                            "event_card_image" => get_field("event_card_image", $e),
                            "event_card_short_description" => get_field("event_card_short_description", $e),
                            "event_card_short_button_text" => get_field("event_card_short_button_text", $e),
                            "permalink" => get_permalink($e),
                            "post_type" => get_field("event_type", $e)
                        ]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($remaining > 0) : ?>
            <div class="hstack justify-content-center align-items-center">
                <button class="btn btn-sm btn-sq-tertiary rounded-pill" data-remaining="<?= $remaining; ?>" data-limit="<?= $limit; ?>" data-page="<?= $page; ?>" id="load-more-events">
                    טען עוד
                    <span>(<?= $remaining; ?>)</span>
                </button>
            </div>
        <?php endif; ?>
    </main>
</section>

<section class="container-fluid px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>

<script>
    $(() => {
        $("#search_form").on("change", function(event) {
            event.preventDefault();

            const formData = new FormData(event.currentTarget);
            const data = {
                course: formData.get("course") ? true : false,
                event: formData.get("event") ? true : false,
                done: formData.get("done") ? true : false,
                query: formData.get("query"),
                nonce: "<?= wp_create_nonce("filter_events_nonce"); ?>",
                action: "filter_events",
            };

            $.ajax({
                url: "<?= admin_url("admin-ajax.php"); ?>",
                method: "POST",
                data,
                dataType: "json",
                success: function(response) {
                    const events = response.events ?? null;

                    if (events) {
                        $("#events-container").html(events);
                        $("#load-more-events").fadeOut();
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Handles the load more functionallity
        $("#load-more-events").on("click", function() {
            const limit = $(this).attr("data-limit");
            const page = $(this).attr("data-page");

            const data = {
                limit,
                page,
                nonce: "<?= wp_create_nonce("load_events_nonce"); ?>",
                action: "load_events",
            };

            $.ajax({
                url: "<?= admin_url("admin-ajax.php"); ?>",
                method: "POST",
                data,
                dataType: "json",
                beforeSend: function() {
                    $(this).prop("disabled", true);
                },
                success: function(response) {
                    const events = response.events ?? [];
                    const remaining = response.remaining ?? 0;

                    $("#events-container").append(events);
                    $("#load-more-events span").html(`(${remaining})`);

                    if (remaining > 0) {
                        $("#load-more-events").attr(
                            "data-page",
                            parseInt(page) + 1
                        );
                    } else {
                        $("#load-more-events").fadeOut();
                    }
                },
                error: function(error) {
                    console.error(error);
                },
                complete: function() {
                    $(this).prop("disabled", false);
                },
            });
        });
    });
</script>

<?php get_footer(); ?>