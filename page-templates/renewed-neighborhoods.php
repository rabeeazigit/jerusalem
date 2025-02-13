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

?>

<!-- HEADER SECTION -->
<?php
// getting section scf
$header_title = get_field("header_title") ?? null;
$header_description = get_field("header_description") ?? null;
$map_placeholder_image = get_field("map_placeholder_image") ?? null;
?>

<?php get_template_part("template-parts/navbar"); ?>


<main class="hero_section_bg">
    <!-- Header Section -->
    <div class="container-fluid px-3 px-md-5 py-5">
        <?php if (function_exists("yoast_breadcrumb")) : ?>
            <div class="sq_breadcrumbs fs-5">
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
        <div class="row mb-5">
            <?php
            $project_status = get_terms([
                "taxonomy" => "project-status",
                "hide_empty" => true,
            ]);
            ?>

            <!-- Project Status Collapse -->
            <div class="col-md-3">
                <div class="border rounded-4 py-3 px-4 bg-white">
                    <div class="hstack align-items-center justify-content-between active show project_status_collapse" data-bs-toggle="collapse" data-bs-target="#project_status_list" style="cursor: pointer">
                        <div class="fs-5 fw-bold">
                            מקרא סטטוס הפרויקט
                        </div>

                        <img src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>" class="project_status_arrow" style="object-fit: cover; object-position: center; width: 24px; height: 24px">
                    </div>

                    <?php if ($project_status && is_array($project_status) && !empty($project_status)) : ?>
                        <div id="project_status_list" class="collapse show">
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
                <?php if ($map_placeholder_image) : ?>
                    <img src="<?= $map_placeholder_image; ?>" class="project_map_placeholder w-100">
                <?php endif; ?>
            </div>
        </div>

        <!-- Projects Section -->
        <?php
        $neightborhoods = get_posts([
            "post_type" => "neighborhood",
            "posts_per_page" => -1
        ]);
        ?>
        <div class="container-fluid px-3 px-md-5">
            <div class="display-4 fw-bold text-center mb-4">
                פרויקטים
            </div>
        </div>

        <div class="udc_search_container">
            <div class="row">
                <div class="col-md-3">
                    <?php if ($neightborhoods && is_array($neightborhoods) && !empty($neightborhoods)) : ?>
                        <select id="neighborhood_select" class="form-select rounded-pill">
                            <option selected value="" disabled>שכונה</option>
                            <?php foreach ($neightborhoods as $e) : ?>
                                <option value="<?= $e->ID; ?>">
                                    <?= $e->post_title; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="col-md-3">
                    <?php if ($project_status && is_array($project_status) && !empty($project_status)) : ?>
                        <select id="project_status_select" class="form-select rounded-pill">
                            <option selected value="" disabled>סטטוס הפרויקט</option>
                            <?php foreach ($project_status as $e) : ?>
                                <option value="<?= $e->ID; ?>">
                                    <?= $e->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

                <div class="col-md-5">
                    <div class="input-group bg-white rounded-pill border overflow-hidden">
                        <span class="input-group-text border-0" style="background-color: transparent;">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text" class="form-control border-0" id="search_input" placeholder="חיפוש פרויקט">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>