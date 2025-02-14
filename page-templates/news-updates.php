<?php

// Template Name: News And Updates

get_header();
?>

<header class="container-fluid px-0 text-light">
    <div class="linear_bg_page py-5">
        <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>
        <?php
        $main_title = get_field("main_title") ?? null;
        $sub_title = get_field("sub_title") ?? null;
        ?>
        <div class="vstack my-3 px-md-5 px-3">
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
    <main class="container px-md-5 px-3">
        <?php
        $articles_title = get_field("articles_title") ?? null;
        $limit = 7;
        $page = 1;
        $articles = get_posts([
            "post_type" => "article",
            "posts_per_page" => $limit,
            "paged" => $page,
        ]);
        $remaining = max(0, wp_count_posts("article")->publish - count($articles));
        ?>

        <?php if ($articles_title) : ?>
            <div class="display-4 fw-bold text-center mb-3">
                <?= $articles_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($articles && is_array($articles) && !empty($articles)) : ?>
            <div class="hstack justify-content-center">
                <div class="input-group bg-white rounded-pill border overflow-hidden mb-5 <?= wp_is_mobile() ? "w-100" : "w-50"; ?>">
                    <span class="input-group-text border-0" style="background-color: transparent;">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" class="form-control border-0" name="query" id="search_input" placeholder="חיפוש">
                </div>
            </div>

            <div class="vstack" id="articles-container">
                <?php foreach ($articles as $e) : ?>
                    <?php
                    $title = $e->post_title ?? null;
                    $image = get_field("article_image", $e) ?? null;
                    $description = get_field("article_description", $e) ?? null;
                    $date = get_field("article_date", $e) ?? null;


                    ?>

                    <?php if (!wp_is_mobile()) : ?>
                        <div class="hstack gap-5 justify-content-between align-items-start py-5 article_card_elm">
                            <?php if ($date) : ?>
                                <?php
                                $month = explode(" | ", $date)[1] ?? "";
                                $day = explode("/", explode(" | ", $date)[0])[0];
                                $year = explode("/", explode(" | ", $date)[0])[2];
                                ?>
                                <div class="vstack">
                                    <div class="fw-semibold fs-4">
                                        <?= $day; ?>
                                    </div>

                                    <div class="opacity-75">
                                        <?= $month; ?>
                                    </div>

                                    <div class="opacity-75">
                                        <?= $year; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($title || $description) : ?>
                                <div class="vstack gap-2">
                                    <?php if ($title) : ?>
                                        <div class="fs-4 fw-bold">
                                            <?= $title; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($description) : ?>
                                        <div class="fs-6">
                                            <?= $description; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($image) : ?>
                                <img class="article_display_image" src="<?= $image; ?>" alt="<?= $title; ?>" class="img-fluid w-100 object-fit-cover rounded-4">
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="vstack gap-2 justify-content-between align-items-start py-3 article_card_elm">
                            <?php if ($image) : ?>
                                <img class="article_display_image" src="<?= $image; ?>" alt="<?= $title; ?>" class="img-fluid w-100 object-fit-cover rounded-4">
                            <?php endif; ?>

                            <div class="hstack gap-2">
                                <?php if ($date) : ?>
                                    <?php
                                    $month = explode(" | ", $date)[1] ?? "";
                                    $day = explode("/", explode(" | ", $date)[0])[0];
                                    $year = explode("/", explode(" | ", $date)[0])[2];
                                    ?>
                                    <div class="vstack">
                                        <div class="fw-semibold fs-4">
                                            <?= $day; ?>
                                        </div>

                                        <div class="opacity-75">
                                            <?= $month; ?>
                                        </div>

                                        <div class="opacity-75">
                                            <?= $year; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($title || $description) : ?>
                                    <div class="vstack gap-2">
                                        <?php if ($title) : ?>
                                            <div class="fs-5 fw-bold">
                                                <?= $title; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($description) : ?>
                                            <div class="fs-6">
                                                <?= truncate_sentence($description, 64); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($remaining > 0) : ?>
            <div class="hstack justify-content-center align-items-center">
                <button class="btn btn-sm btn-sq-tertiary rounded-pill" data-remaining="<?= $remaining; ?>" data-limit="<?= $limit; ?>" data-page="<?= $page; ?>" id="loadMoreArticles">
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
        // handles the filtering logic
        $("#search_input").on("change", function(event) {
            const query = $(this).val();

            const data = {
                query,
                action: "search_articles",
                nonce: "<?= wp_create_nonce("search_articles_nonce"); ?>"
            };

            // if the filter is cleared
            if (!query) {
                window.location.reload();
                return;
            }

            $.ajax({
                url: "<?= admin_url("admin-ajax.php"); ?>",
                method: "POST",
                data,
                dataType: "json",
                beforeSend: function() {
                    $(this).prop("disabled", true);
                },
                success: function(response) {
                    console.log(response);
                    const articles = response.articles ?? null;

                    $("#articles-container").html(articles);
                    $("#loadMoreArticles").fadeOut();
                },
                error: function(error) {
                    console.error(error);
                },
                complete: function() {
                    $(this).prop("disabled", false);
                },
            });
        });

        // Handles the load more functionallity
        $("#loadMoreArticles").on("click", function() {
            const limit = $(this).attr("data-limit");
            const page = $(this).attr("data-page");

            const data = {
                limit,
                page,
                nonce: "<?= wp_create_nonce("load_articles_nonce"); ?>",
                action: "load_articles",
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
                    const articles = response.articles ?? [];
                    const remaining = response.remaining ?? 0;

                    $("#articles-container").append(articles);
                    $("#loadMoreArticles span").html(`(${remaining})`);

                    if (remaining > 0) {
                        $("#loadMoreArticles").attr(
                            "data-page",
                            parseInt(page) + 1
                        );
                    } else {
                        $("#loadMoreArticles").fadeOut();
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