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

        add_action("wp_ajax_sq_site_search", [$this, "sq_site_search"]);
        add_action("wp_ajax_nopriv_sq_site_search", [$this, "sq_site_search"]);
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
                    "project_address" => get_field("project_address", $e) ?? null,
                    "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                    "project_status" => get_field("project_status", $e) ?? null,
                    "project_card_image" => get_field("project_card_image", $e) ?? null,
                    "project_name" => $e->post_title ?? null,
                    "project_link" => get_permalink($e) ?? null,
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

        <?php if ($projects && is_array($projects) && !empty($projects)) : ?>
            <?php foreach ($projects as $e) : ?>
                <div class="col-xl-3 col-md-4">
                    <?php get_template_part("template-parts/project-card", null, [
                        "project_address" => get_field("project_address", $e) ?? null,
                        "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                        "project_status" => get_field("project_status", $e) ?? null,
                        "project_card_image" => get_field("project_card_image", $e) ?? null,
                        "project_name" => $e->post_title ?? null,
                        "project_link" => get_permalink($e) ?? null,
                    ]) ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="hstack align-items-center justify-content-center">
                    <div class="fs-5 py-4 fw-bold">
                        לא נמצאו פרויקטים
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
            "meta_key" => "article_date", 
            "orderby" => "meta_value_num", 
            "order" => "DESC",
            "meta_query" => [
                [
                    "key" => "article_date", 
                    "compare" => "EXISTS", 
                ],
            ],
        ];
        
        $articles_query = new WP_Query($args);
        $articles = $articles_query->posts;

        ob_start(); ?>
        <?php foreach ($articles as $e) : ?>
                <?php
                $title = $e->post_title ?? null;
                $image = get_field("article_image", $e) ?? null;
                $description = get_field("article_description", $e) ?? null;
                $date = get_field("article_date", $e) ?? null;
                ?>

                <?php if (!wp_is_mobile()) : ?>
                    <a href="<?= get_permalink($e); ?>" class="text-reset text-decoration-none hstack gap-5 justify-content-start align-items-start py-5 article_card_elm">
                        <?php if ($date) : ?>
                            <?php
                            $month = explode(" | ", $date)[1] ?? "";
                            $day = explode("/", explode(" | ", $date)[0])[0];
                            $year = explode("/", explode(" | ", $date)[0])[2];
                            ?>
                            <div class="col-1">
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
                            </div>
                        <?php endif; ?>

                        <?php if ($title || $description) : ?>
                            <div class="col">
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
                            </div>
                        <?php endif; ?>

                        <?php if ($image) : ?>
                            <div class="col-3">
                                <img src="<?= $image; ?>" alt="<?= $title; ?>" class="img-fluid w-100 object-fit-cover rounded-4 article_display_image">
                            </div>
                        <?php endif; ?>
                    </a>
                <?php else : ?>
                    <a href="<?= get_permalink($e); ?>" class="text-reset text-decoration-none vstack gap-2 justify-content-between align-items-start py-3 article_card_elm">
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
                    </a>
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
                <a href="<?= get_permalink($e); ?>" class="text-reset text-decoration-none hstack gap-5 justify-content-start align-items-start py-5 article_card_elm">
                    <?php if ($date) : ?>
                        <?php
                        $month = explode(" | ", $date)[1] ?? "";
                        $day = explode("/", explode(" | ", $date)[0])[0];
                        $year = explode("/", explode(" | ", $date)[0])[2];
                        ?>
                        <div class="col-1">
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
                        </div>
                    <?php endif; ?>

                    <?php if ($title || $description) : ?>
                        <div class="col">
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
                        </div>
                    <?php endif; ?>

                    <?php if ($image) : ?>
                        <div class="col-3">
                            <img src="<?= $image; ?>" alt="<?= $title; ?>" class="img-fluid w-100 object-fit-cover rounded-4 article_display_image">
                        </div>
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a href="<?= get_permalink($e); ?>" class="text-reset text-decoration-none vstack gap-2 justify-content-between align-items-start py-3 article_card_elm">
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
                </a>
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

    public function sq_site_search()
    {
        try {
            $is_nonce_valid = check_ajax_referer("sq_site_search", "security", false);

            if (!$is_nonce_valid) {
                wp_send_json([
                    "data" => null,
                    "error" => "Unauthrozied"
                ], 401);
            }

            $query = $_POST["query"] ?? null;

            if (!$query) {
                wp_send_json([
                    "data" => [],
                    "error" => null
                ], 404);
            }

            $posts = get_posts([
                "post_type" => [
                    "page",
                    "project",
                    "event",
                    "article",
                    "forum",
                    "course",
                    "neighborhood",
                    "area-fields",
                    "urban-renewal-proces",
                    "resident-right",
                    "downloadable-file",
                    "faq",
                    "ur-stage-details"
                ],
                "post_status" => "publish",
                "posts_per_page" => -1,
                "s" => $query
            ]);

            ob_start();
        ?>
            <div class="vstack gap-3">
                <?php if (count($posts) > 0) : ?>
                    <?php foreach ($posts as $e) : ?>
                        <a class="sq-search-item py-3 text-reset text-decoration-none" href="<?= get_permalink($e); ?>">
                            <div class="fs-5">
                                <?= $e->post_title; ?>
                            </div>

                            <div class="sq-search-item-arrow"></div>
                        </a>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="hstack align-items-center justify-content-center py-4">
                        <div class="fs-5">
                            לא נמצאו תוצאות
                        </div>
                    </div>
                <?php endif; ?>
            </div>
<?php
            wp_send_json([
                "data" => ob_get_clean(),
                "error" => null
            ], 200);
        } catch (Throwable $error) {
            wp_send_json([
                "data" => null,
                "error" => $error->getMessage()
            ], 500);
        }
    }
}
