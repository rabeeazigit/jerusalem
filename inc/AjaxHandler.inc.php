<?php

class AjaxHandler
{
    public function __construct()
    {
        add_action("wp_ajax_load_projects", [$this, "load_projects"]);
        add_action("wp_ajax_nopriv_load_projects", [$this, "load_projects"]);

        add_action("wp_ajax_get_filtered_projects", [$this, "get_filtered_projects"]);
        add_action("wp_ajax_nopriv_get_filtered_projects", [$this, "get_filtered_projects"]);

        add_action("wp_ajax_load_articles", [$this, "load_articles"]);
        add_action("wp_ajax_nopriv_load_articles", [$this, "load_articles"]);

        add_action("wp_ajax_search_articles", [$this, "search_articles"]);
        add_action("wp_ajax_nopriv_search_articles", [$this, "search_articles"]);

        add_action("wp_ajax_load_events", [$this, "load_events"]);
        add_action("wp_ajax_nopriv_load_events", [$this, "load_events"]);

        add_action("wp_ajax_filter_events", [$this, "filter_events"]);
        add_action("wp_ajax_nopriv_filter_events", [$this, "filter_events"]);
    }

    public function load_projects()
    {
        check_ajax_referer("load_projects_nonce", "nonce");

        $limit = isset($_POST["limit"]) ? intval($_POST["limit"]) : 16;
        $page  = isset($_POST["page"]) ? intval($_POST["page"]) : 1;

        $args = [
            "post_type" => "project",
            "posts_per_page" => $limit,
            "paged" => $page,
            "post_status" => "publish",
        ];

        $projects = get_posts($args);
        ob_start(); ?>
        <?php foreach ($projects as $e) : ?>
            <div class="col-md-3">
                <?php get_template_part("template-parts/project-card", null, [
                    "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                    "project_status" => get_field("project_status", $e) ?? null,
                    "project_card_image" => get_field("project_card_image", $e) ?? null,
                    "project_name" => $e->post_title ?? null,
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php
        $project_html = ob_get_clean();
        $total_projects = wp_count_posts("project")->publish;

        wp_send_json([
            "projects" => $project_html,
            "remaining" => max(0, $total_projects - (($page + 1) * $limit))
        ]);
    }

    public function get_filtered_projects()
    {
        check_ajax_referer("load_projects_nonce", "nonce");

        $neighborhood = $_POST["neighborhood"] ?? null;
        $project_status = $_POST["projectStatus"] ?? null;
        $search_query = $_POST["query"] ?? null;

        $args = [
            "post_type" => "project",
            "posts_per_page" => -1,
            "post_status" => "publish",
            "s" => $search_query,
            "meta_query" => [],
            "tax_query" => [],
        ];

        if ($neighborhood) {
            $args["meta_query"][] = [
                "key" => "project_neighborhood",
                "compare" => "=",
                "value" => $neighborhood,
            ];
        }

        if ($project_status) {
            $args["tax_query"][] = [
                "taxonomy" => "project-status",
                "field" => "term_id",
                "terms" => $project_status,
                "compare" => "=",
            ];
        }


        $projects = get_posts($args);
        ob_start(); ?>

        <?php foreach ($projects as $e) : ?>
            <div class="col-md-3">
                <?php get_template_part("template-parts/project-card", null, [
                    "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                    "project_status" => get_field("project_status", $e) ?? null,
                    "project_card_image" => get_field("project_card_image", $e) ?? null,
                    "project_name" => $e->post_title ?? null,
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php
        $projects_html = ob_get_clean();

        wp_send_json([
            "projects" => $projects_html
        ]);
    }

    public function load_articles()
    {
        check_ajax_referer("load_articles_nonce", "nonce");

        $limit = isset($_POST["limit"]) ? intval($_POST["limit"]) : 16;
        $page  = isset($_POST["page"]) ? intval($_POST["page"]) : 1;

        $args = [
            "post_type" => "article",
            "posts_per_page" => $limit,
            "paged" => $page,
            "post_status" => "publish",
        ];

        $articles = get_posts($args);
        ob_start(); ?>
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
    <?php
        $article_html = ob_get_clean();
        $total_articles = wp_count_posts("article")->publish;

        wp_send_json([
            "articles" => $article_html,
            "remaining" => max(0, $total_articles - (($page + 1) * $limit))
        ]);
    }

    public function search_articles()
    {
        check_ajax_referer("search_articles_nonce", "nonce");

        $search_query = $_POST["query"] ?? null;

        $args = [
            "post_type" => "article",
            "posts_per_page" => -1,
            "post_status" => "publish",
            "s" => $search_query
        ];
        $regular_search = get_posts($args);

        $acf_args = [
            "post_type" => "article",
            "posts_per_page" => -1,
            "post_status" => "publish",
            "exclude" => array_map(fn($e) => $e->ID, $regular_search),
            "meta_query" => [
                "relation" => "OR",
                [
                    "key" => "article_description",
                    "value" => $search_query,
                    "compare" => "LIKE"
                ]
            ]
        ];

        $advanced_search = get_posts($acf_args);

        $articles = [...$regular_search, ...$advanced_search];
        ob_start(); ?>

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
    <?php
        $articles_html = ob_get_clean();

        wp_send_json([
            "articles" => $articles_html
        ]);
    }

    public function load_events()
    {
        check_ajax_referer("load_events_nonce", "nonce");

        $limit = isset($_POST["limit"]) ? intval($_POST["limit"]) : 16;
        $page  = isset($_POST["page"]) ? intval($_POST["page"]) : 1;

        $args = [
            "post_type" => ["event", "forum"],
            "posts_per_page" => $limit,
            "paged" => $page,
            "post_status" => "publish",
        ];

        $events = get_posts($args);
        ob_start(); ?>
        <?php foreach ($events as $e) : ?>
            <div class="col-md-4 col-12">
                <?php get_template_part("template-parts/event-card", null, [
                    "event_name" => $e->post_title,
                    "event_occurrence_date" => get_field("event_occurrence_date", $e),
                    "event_place" => get_field("event_place", $e),
                    "event_card_image" => get_field("event_card_image", $e),
                    "event_card_short_description" => get_field("event_card_short_description", $e),
                    "event_card_short_button_text" => get_field("event_card_short_button_text", $e),
                    "permalink" => get_permalink($e),
                    "post_type" => get_post_type($e) == "forum" ? "forum" : get_field("event_type", $e)
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php
        $events_html = ob_get_clean();
        $total_events = wp_count_posts("event")->publish;

        wp_send_json([
            "events" => $events_html,
            "remaining" => max(0, $total_events - (($page + 1) * $limit))
        ]);
    }

    public function filter_events()
    {
        check_ajax_referer("filter_events_nonce", "nonce");

        $event = isset($_POST["event"]) && $_POST["event"] == "true";
        $course = isset($_POST["course"]) && $_POST["course"] == "true";
        $query = $_POST["query"] ?? "";
        $done = isset($_POST["done"]) && $_POST["done"] == "true";
        $meta_query = [
            "relation" => "OR",
        ];

        if ($event) {
            $meta_query[] = [
                "key" => "event_type",
                "value" => "event",
                "compare" => "="
            ];
        }

        if ($course) {
            $meta_query[] = [
                "key" => "event_type",
                "value" => "course",
                "compare" => "="
            ];
        }

        if ($query) {
            $meta_query[] = [
                "key" => "event_card_short_description",
                "value" => $query,
                "compare" => "LIKE"
            ];
        }

        if ($done) {
            $meta_query[] = [
                "key" => "event_occurrence_date",
                "value" => date("Ymd"),
                "compare" => "<",
                "type" => "DATE"
            ];
        }

        if (empty($meta_query)) {
            $meta_query[] = [
                "key" => "event_type",
                "compare" => "EXISTS"
            ];
        }

        $args = [
            "post_type" => ["event", "forum"],
            "posts_per_page" => -1,
            "post_status" => "publish",
            "meta_query" => $meta_query
        ];
        $result_1 = get_posts($args);

        $args = [
            "post_type" => "event",
            "posts_per_page" => -1,
            "post_status" => "publish",
            "exclude" => array_map(fn($e) => $e->ID, $result_1),
            "s" => $query,
            "meta_query" => $meta_query
        ];
        $result_2 = get_posts($args);


        $events = [...$result_1, ...$result_2];
        ob_start(); ?>
        <?php foreach ($events as $e) : ?>
            <div class="col-md-4 col-12">
                <?php get_template_part("template-parts/event-card", null, [
                    "event_name" => $e->post_title,
                    "event_occurrence_date" => get_field("event_occurrence_date", $e),
                    "event_place" => get_field("event_place", $e),
                    "event_card_image" => get_field("event_card_image", $e),
                    "event_card_short_description" => get_field("event_card_short_description", $e),
                    "event_card_short_button_text" => get_field("event_card_short_button_text", $e),
                    "permalink" => get_permalink($e),
                    "post_type" => get_post_type($e) == "forum" ? "forum" : get_field("event_type", $e)
                ]) ?>
            </div>
        <?php endforeach; ?>
<?php
        $events_html = ob_get_clean();

        wp_send_json([
            "events" => $events_html,
        ]);
    }
}
