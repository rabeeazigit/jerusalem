<?php

// Template Name: Events And Articles

get_header();
?>

<?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>

<style>
    .top-nav-bar {
        background: linear-gradient(70deg, #174a74 85%, #376a93);   
    }

    .text-mb-white {
        color: white !important;
    }
</style>

<main class="container-fluid px-0 text-light">
    <div class="linear_bg_page">
        <?php
        $main_title = get_field("main_title") ?? null;
        $sub_title = get_field("sub_title") ?? null;
        ?>
        <div class="vstack pt-4 px-md-5 px-3">
            <?php if (function_exists("yoast_breadcrumb")) : ?>
                <div class="sq_breadcrumbs py-3 fs-5">
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
</main>

<section class="article_wrapper py-5">
    <main class="container-fluid events-container">
        <?php
        $posts_title = get_field("posts_title") ?? null;
        $limit = 12;
        $page = 1;
        $posts = get_posts([
            "post_type" => ["event", "forum"],
            "posts_per_page" => $limit,
            "paged" => $page++,
        ]);
        $remaining = max(0, wp_count_posts("event")->publish - count($posts));
        ?>

        <?php if ($posts_title) : ?>
            <div class="display-4 fw-bold text-center mb-3">
                <?= $posts_title; ?>
            </div>
        <?php endif; ?>

        <?php 
        // get the categories that are not empty
        // so we can filter using them
        $media_categories = get_terms([
            'taxonomy' => 'event-category',
            'hide_empty' => true
        ]);

        // get the target audiences that are not empty
        // so we can filter using them
        $media_audiences = get_terms([
            'taxonomy' => 'event-audience',
            'hide_empty' => true
        ]);
        ?>
        
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
                    <?php foreach ($media_audiences as $term) : ?>
                        <div>
                            <input type="checkbox" class="btn-check event_filter_btn" name="event_audience" id="<?= $term->slug; ?>" data-term-id="<?= $term->term_id; ?>">
                            <label for="<?= $term->slug; ?>" class="btn btn-outline-sq-gold rounded-pill">
                                <?= $term->name; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                    
                    <div>
                        <input type="checkbox" class="btn-check event_filter_btn" name="done" id="done">
                        <label for="done" class="btn btn-outline-sq-primary rounded-pill">התקיימו</label>
                    </div>
                </div>
                    
                <?php if ($media_audiences && is_array($media_audiences) && !empty($media_audiences)) : ?>
                    <hr class="my-0" />
                <?php endif; ?>
                
                <div class="col-12 hstack gap-3 justify-content-center flex-wrap">
                    <?php foreach ($media_categories as $term) : ?>
                        <div>
                            <input type="checkbox" class="btn-check event_filter_btn" name="event_category" id="<?= $term->slug; ?>" data-term-id="<?= $term->term_id; ?>">
                            <label for="<?= $term->slug; ?>" class="btn btn-outline-sq-primary rounded-pill">
                                <?= $term->name; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <div>
                        <input type="checkbox" class="btn-check event_filter_btn" name="done" id="done">
                        <label for="done" class="btn btn-outline-sq-primary rounded-pill">התקיימו</label>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <form id="search_form" class="vstack gap-2">
                <div class="hstack gap-2 align-items-center justify-content-center mb-5">
                    <?php foreach ($media_audiences as $term) : ?>
                        <div>
                            <input type="checkbox" class="btn-check event_filter_btn" name="event_audience" id="<?= $term->slug; ?>" data-term-id="<?= $term->term_id; ?>">
                            <label for="<?= $term->slug; ?>" class="btn btn-outline-sq-gold rounded-pill">
                                <?= $term->name; ?> 
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($media_audiences && is_array($media_audiences) && !empty($media_audiences)) : ?>
                        <div class="vr"></div>
                    <?php endif; ?>
                    
                    <?php foreach ($media_categories as $e) : ?>
                        <input type="checkbox" class="btn-check event_filter_btn" name="event_category" id="<?= $e->slug; ?>" data-term-id="<?= $e->term_id; ?>">
                        <label for="<?= $e->slug; ?>" class="btn btn-outline-sq-primary rounded-pill">
                            <?= $e->name; ?>
                        </label>
                    <?php endforeach; ?>

                    <input type="checkbox" class="btn-check event_filter_btn" name="done" id="done">
                    <label for="done" class="btn btn-outline-sq-primary rounded-pill">התקיימו</label>

                    <div class="input-group bg-white rounded-pill border overflow-hidden event_searchbar">
                        <span class="input-group-text border-0" style="background-color: transparent;">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" id="query_search" class="form-control border-0" name="query" placeholder="חיפוש">
                    </div>
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
                            "post_type" => get_field("event_type", $e) ? get_field("event_type", $e)->name : null
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
        // listen for scroll
        // hide blue background when navbar is sticky
        $(window).on("scroll", function () {
            // Get the current scrollY of the screen
            const currentY = window.scrollY;

            if (currentY >= 120) {
                $("#main-sticky-navbar-sticky-section").removeClass("linear_bg_page");
            } else {
                $("#main-sticky-navbar-sticky-section").addClass("linear_bg_page");
            }
        });
        
        $("#search_form").on("submit", function (ev) {
            ev.preventDefault();
        });
        
        $("#search_form").on("input", function(event) {
            event.preventDefault();

            const eventCategory = [];
            const eventAudience = [];

            $("input[name=event_category]:checked").each(function () {
                eventCategory.push($(this).data("term-id"));
            });

            $("input[name=event_audience]:checked").each(function () {
                eventAudience.push($(this).data("term-id"));
            });
            
            const formData = new FormData(event.currentTarget);
            const data = {
                eventCategory,
                eventAudience,
                done: formData.get("done") ? true : false,
                query: formData.get("query"),
                nonce: "<?= wp_create_nonce("filter_events_nonce"); ?>",
                action: "filter_events",
            };

            console.log(data);
            
            $.ajax({
                url: "<?= admin_url("admin-ajax.php"); ?>",
                method: "POST",
                data,
                dataType: "json",
                beforeSend: function () {
                    $("#load-more-events").hide();

                    $("#events-container").html(`
                        <div class="d-flex justify-content-center py-5">
                            <div class="spinner-border sq-text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>  
                        </div>
                    `);
                },
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