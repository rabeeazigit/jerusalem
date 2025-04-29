<?php

// Template Name: Renewd Neighborhoods

get_header();

wp_enqueue_style(
    "renewed_neighborhoods_css",
    get_template_directory_uri() . "/assets/css/renewed-neighborhoods.css",
    ["main_css"],
    filemtime(get_template_directory() . "/assets/css/renewed-neighborhoods.css"),
    "all"
);

wp_enqueue_script(
    "renewed_neighborhoods_js",
    get_template_directory_uri() . "/assets/js/renewed-neighborhoods.js",
    ["jquery_cdn"],
    filemtime(get_template_directory() . "/assets/js/renewed-neighborhoods.js")
);

wp_localize_script("renewed_neighborhoods_js", "ajaxObject", [
    "ajaxUrl" => admin_url("admin-ajax.php"),
    "nonce" => wp_create_nonce("load_projects_nonce")
]);

?>

<!-- HEADER SECTION -->
<?php
// getting section scf
$header_title = get_field("header_title") ?? null;
$header_description = get_field("header_description") ?? null;
// $map_placeholder_image = get_field("map_placeholder_image") ?? null;
?>

<?php get_template_part("template-parts/navbar"); ?>


<section class="hero_section_bg">
    <!-- Header Section -->
    <div class="container-fluid px-3 px-md-5 py-5">
        <?php if (function_exists("yoast_breadcrumb")) : ?>
            <div class="sq_breadcrumbs fs-5 mb-4 mb-md-0">
                <?php yoast_breadcrumb(); ?>
            </div>
        <?php endif; ?>

        <?php if ($header_title) : ?>
            <div class="display-2 fw-bold text-center mb-2">
                <?= $header_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($header_description) : ?>
            <div class="fs-5 text-center mb-5">
                <?= $header_description; ?>
            </div>
        <?php endif; ?>

        <!-- Map & Project Status -->
        <div class="row mb-5 row-gap-3 row-gap-md-0">
            <?php
            $project_status = get_terms([
                "taxonomy" => "project-status",
                "hide_empty" => true,
            ]);
            ?>

            <!-- Project Status Collapse -->
            <div class="col-md-3">
                <div class="border rounded-4 py-3 px-4 bg-white">
                    <div class="hstack align-items-center justify-content-between <?= !wp_is_mobile() ? "active show" : ""; ?> project_status_collapse" data-bs-toggle="collapse" data-bs-target="#project_status_list" style="cursor: pointer">
                        <div class="fs-5 fw-bold">
                            מקרא סטטוס הפרויקט
                        </div>

                        <img src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>" class="project_status_arrow" style="object-fit: cover; object-position: center; width: 24px; height: 24px">
                    </div>

                    <?php if ($project_status && is_array($project_status) && !empty($project_status)) : ?>
                        <div id="project_status_list" class="collapse <?= !wp_is_mobile() ? "show" : ""; ?>">
                            <div>
                                <div class="vstack pt-2">
                                    <?php foreach ($project_status as $i => $e) : ?>
                                        <div class="hstack gap-2 align-items-start py-3 project_status_wrapper_rwduc">
                                            <?php
                                            $status_color = get_field("project_status_color", $e);
                                            $status_name = $e->name;
                                            ?>

                                            <?php if ($status_color) : ?>
                                                <div class="project_status_color" style="background-color: <?= $status_color; ?>;"></div>
                                            <?php endif; ?>

                                            <?php if ($status_name) : ?>
                                                <div class="fs-6">
                                                    <?= $status_name; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Map -->
            <div class="col project_map_wrapper">
                <?php
                    get_template_part('template-parts/map-temp');
                ?>
                <!-- <?php if ($map_placeholder_image) : ?>
                    <img src="<?= $map_placeholder_image; ?>" class="project_map_placeholder w-100">
                <?php endif; ?> -->
            </div>
        </div>

        <!-- Projects Section -->
        <?php
        $projects_title = get_field("projects_title") ?? null;
        $neightborhoods = get_posts([
            "post_type" => "neighborhood",
            "posts_per_page" => -1
        ]);
        ?>
        <div class="container-fluid px-3 px-md-5" id="projects">
            <?php if ($projects_title) : ?>
                <div class="display-4 fw-bold text-center mb-4">
                    <?= $projects_title; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="udc_search_container">
            <form class="row row-gap-3 gx-3" id="neighborhoods_search">
                <div class="col-md-3 col-6">
                    <?php if ($neightborhoods && is_array($neightborhoods) && !empty($neightborhoods)) : ?>
                        <select id="neighborhood_select" name="neighborhood" class="form-select rounded-pill">
                            <option selected value="">שכונה</option>
                            <?php foreach ($neightborhoods as $e) : ?>
                                <option value="<?= $e->ID; ?>">
                                    <?= $e->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="col-md-3 col-6">
                    <?php if ($project_status && is_array($project_status) && !empty($project_status)) : ?>
                        <select id="project_status_select" name="project_status" class="form-select rounded-pill">
                            <option selected value="">סטטוס הפרויקט</option>
                            <?php foreach ($project_status as $e) : ?>
                                <option value="<?= $e->term_id; ?>">
                                    <?= $e->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="col-md-4 col-12">
                    <div class="input-group bg-white rounded-pill border overflow-hidden">
                        <span class="input-group-text border-0" style="background-color: transparent;">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" class="form-control border-0" name="query" id="search_input" placeholder="חיפוש פרויקט">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Project Numbers Section -->
<?php
$projects_numbers = get_field("projects_numbers") ?? null;
?>
<section class="container-fluid px-3 px-md-5">
    <?php if ($projects_numbers && is_array($projects_numbers) && !empty($projects_numbers)) : ?>
        <hr>

        <div class="row justify-content-center row-gap-4 py-2">
            <?php foreach ($projects_numbers as $e) : ?>
                <?php
                $label = $e["label"] ?? null;
                $number = $e["number"] ?? null;
                ?>
                <?php if (wp_is_mobile()) : ?>
                    <div class="col-md-4 col-6">
                        <div class="vstack align-items-center justify-content-center">
                            <div class="fs-2 fw-bold">
                                <?= $number; ?>
                            </div>

                            <div class="fs-5 opacity-75 text-center">
                                <?= $label; ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="rs-col-5">
                        <div class="vstack align-items-center justify-content-center">
                            <div class="fs-2 fw-bold">
                                <?= $number; ?>
                            </div>

                            <div class="fs-5 opacity-75">
                                <?= $label; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <hr>
    <?php endif; ?>
</section>

<!-- Projects Grid -->
<?php
// Getting the initial projects to display
$total_projects = wp_count_posts("project")->publish;
$projects_limit = 16;
$projects_page = 1;
$remaining_projects = max(0, $total_projects - $projects_limit);
$projects = get_posts([
    "post_type" => "project",
    "posts_per_page" => $projects_limit,
    "paged" => $projects_page++,
    "post_status" => "publish"
]);
?>
<section class="container-fluid px-3 px-md-5" id="projects-container-after-reset">
    <?php if ($projects && is_array($projects) && !empty($projects)) : ?>
        <div class="row row-gap-3 my-5" id="projects-container">
            <?php if ($projects && is_array($projects) && !empty($projects)) : ?>
                <?php foreach ($projects as $e) : ?>
                    <div class="col-xl-3 col-md-4">
                        <?php get_template_part("template-parts/project-card", null, [
                            "project_address" => get_field("project_address", $e) ?? null,
                            "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                            "project_entrepreneur" => get_field("project_entrepreneur", $e) ?? null,
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
</section>

<section class="my-5">
    <?php get_template_part("template-parts/howcanwehelp"); ?>
</section>

<?php get_footer(); ?>