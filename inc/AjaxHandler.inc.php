<?php

class AjaxHandler
{
    public function __construct()
    {
        add_action("wp_ajax_load_projects", [$this, "load_projects"]);
        add_action("wp_ajax_nopriv_load_projects", [$this, "load_projects"]);

        add_action("wp_ajax_get_filtered_projects", [$this, "get_filtered_projects"]);
        add_action("wp_ajax_nopriv_get_filtered_projects", [$this, "get_filtered_projects"]);

        add_action("wp_ajax_reset_projects", [$this, "reset_projects"]);
        add_action("wp_ajax_nopriv_reset_projects", [$this, "reset_projects"]);
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

    public function reset_projects()
    {
        $total_projects = wp_count_posts("project")->publish;
        $projects_limit = 16;
        $projects_page = 1;
        $remaining_projects = max(0, $total_projects - $projects_limit);
        $projects = get_posts([
            "post_type" => "project",
            "posts_per_page" => $projects_limit,
            "paged" => $projects_page,
            "post_status" => "publish"
        ]);

        ob_start(); ?>
        <?php if ($projects && is_array($projects) && !empty($projects)) : ?>
            <div class="row row-gap-3 my-5" id="projects-container">
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
            </div>
        <?php endif; ?>

        <?php if ($remaining_projects > 0) : ?>
            <div class="hstack justify-content-center align-items-center">
                <button class="btn btn-sm btn-sq-tertiary rounded-pill" data-remaining="<?= $remaining_projects; ?>" data-limit="<?= $projects_limit; ?>" data-page="<?= $projects_page; ?>" id="loadMoreProjects">
                    טען עוד
                    <span>(<?= $remaining_projects; ?>)</span>
                </button>
            </div>
        <?php endif; ?>
<?php
        $html = ob_get_clean();

        wp_send_json([
            "projects" => $html
        ]);
    }
}
