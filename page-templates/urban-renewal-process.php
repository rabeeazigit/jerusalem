<?php

// Template Name: Urban Renewal Process

get_header();
?>

<?php
$controller = new UrbanRenewal();

// Setting up renewual items
$urban_renewal_terms = $controller->get_renewal_categories();
$urban_renewal_items = $controller->get_urban_renewal_processes();
$urban_category = $_GET["urban_category"] ?? null;
?>

<!-- COLORED HERO -->
<div class="container-fluid px-0 py-5 text-light linear_bg_page">
    <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>

    <!-- HERO HEADER -->
    <div class="container-fluid px-md-5 px-3 my-5">
        <div class="vstack gap-3">
            <?php if (function_exists("yoast_breadcrumb")) : ?>
                <div class="sq_breadcrumbs fs-5">
                    <?php yoast_breadcrumb(); ?>
                </div>
            <?php endif; ?>

            <?php if ($controller->hero_title) : ?>
                <div class="display-3 fw-bold rubik">
                    <?= $controller->hero_title; ?>
                </div>
            <?php endif; ?>

            <div class="row my-">
                <div class="col-md-7">
                    <?php if ($controller->hero_subtitle) : ?>
                        <div class="fs-5">
                            <?= $controller->hero_subtitle; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-5">
                    <div class="hstack align-items-center gap-4">
                        <?php if (!wp_is_mobile()) : ?>
                            <div class="vr"></div>
                        <?php endif; ?>

                        <div class="vstack gap-2 mt-4 mt-md-0">
                            <div class="fs-6">
                                עוד בעמוד
                            </div>

                            <?php if (wp_is_mobile()) : ?>
                                <div class="hstack flex-wrap pb-3 px-2 gap-3">
                                    <a href="#urban_renewal_process_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        תהליך התחדשות עירונית
                                    </a>

                                    <a href="#faq_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        שאלות נפוצות
                                    </a>

                                    <a href="#external_links_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        קישורים חיצוניים
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="hstack pb-3 gap-4">
                                    <a href="#urban_renewal_process_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        תהליך התחדשות עירונית
                                    </a>

                                    <a href="#faq_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        שאלות נפוצות
                                    </a>

                                    <a href="#external_links_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill hot-fix-ghost-btn">
                                        קישורים חיצוניים
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Main Row And Columns -->
    <div class="container-fluid px-3 px-md-5">
        <div class="row text-dark row-gap-3" id="urban_renewal_process_section">
            <!-- Stage Selector -->
            <div class="col-md-4">
                <div class="rounded-4 bg-white p-4 sticky-top">
                    <div class="hstack align-items-center justify-content-between">
                        <div class="fs-6 fw-semibold">
                            שלבים
                        </div>

                        <div class="hstack align-items-center border rounded-pill p-1" style="width: fit-content;" role="tablist">
                            <?php foreach ($urban_renewal_terms as $i => $category) : ?>
                                <button class="btn btn-sq-primary text-dark rounded-pill fs-6 uc_category_btn <?= $i == 0 ? "active" : ""; ?>" data-uc-category="<?= $category->name; ?>" data-bs-toggle="tab" data-bs-target="#tab_<?= $i; ?>">
                                    <?= $category->name; ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <hr>

                    <!-- Stages -->
                    <div class="tab-content">
                        <?php $side_stage_count = 0; ?>
                        <?php foreach ($urban_renewal_terms as $i => $category) : ?>
                            <?php $urban_renewal_grouped_items = $controller->get_urban_renewal_processes_grouped_by_stages($category); ?>

                            <?php if ($urban_renewal_grouped_items && is_array($urban_renewal_grouped_items) && !empty($urban_renewal_grouped_items)) : ?>
                                <div class="tab-pane fade <?= $i == 0 ? "active show" : ""; ?>" id="tab_<?= $side_stage_count++; ?>">
                                    <?php foreach ($urban_renewal_grouped_items as $stage => $proccesses) : ?>
                                        <?php
                                        if (!$proccesses || !is_array($proccesses) || empty($proccesses)) {
                                            continue;
                                        }
                                        ?>

                                        <div class="vstack gap-2 mb-3">
                                            <div class="row px-0 rounded-4 border">
                                                <div class="col-2 col-md-1" style="background-color: #EBE8E3">
                                                    <div class="d-flex text-center align-items-center justify-content-center h-100 fw-semibold">
                                                        <?= $stage; ?>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="vstack py-2 gap-2">
                                                        <?php foreach ($proccesses as $index => $process) : ?>
                                                            <div class="vstack">
                                                                <!-- Collapse Anchor -->
                                                                <div class="hstack align-items-center justify-content-between p-3 stage_side_wrapper collapsed" data-bs-toggle="collapse" data-bs-target="#stage_col_<?= $process->ID; ?>">
                                                                    <div class="hstack fs-5 gap-3">
                                                                        <?= ($index + 1 < 10) ? ("0" . $index + 1) : ($index + 1); ?>

                                                                        <div class="vr"></div>

                                                                        <div class="fs-6 fw-semibold">
                                                                            <?= $process->post_title; ?>
                                                                        </div>
                                                                    </div>

                                                                    <img class="stage_side_arrows" src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>" />
                                                                </div>

                                                                <?php
                                                                $side_process_stages = get_field("renewal_stages", $process);
                                                                ?>

                                                                <?php if ($side_process_stages && is_array($side_process_stages) && !empty($side_process_stages)) : ?>
                                                                    <div class="collapse stage_side_collapse" id="stage_col_<?= $process->ID; ?>">
                                                                        <div class="row">
                                                                            <div class="col-md-1"></div>
                                                                            <div class="col">
                                                                                <div class="vstack p-3">
                                                                                    <?php foreach ($side_process_stages as $e) : ?>
                                                                                        <?php if (get_field("stage_title", $e)) : ?>
                                                                                            <div class="fs-6 px-2 rounded-4 renewal_stage_submenu py-4">
                                                                                                <?= get_field("stage_title", $e); ?>
                                                                                            </div>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Stages Display -->
            <div class="col-md-8">
                <div class="rounded-4 bg-white p-4 px-3 px-md-5">
                    <!-- Sticky Title And Search -->
                    <div class="sticky-top bg-white">
                        <div class="hstack align-items-center justify-content-between ">
                            <div class="fs-6 fw-semibold">
                                תהליך התחדשות עירונית
                            </div>

                            <?php if (false) : ?>
                                <div class="input-group rounded-pill overflow-hidden border">
                                    <span class="input-group-text border-none" style=" background-color: white">
                                        <img src="<?= get_template_directory_uri() . "/assets/images/search-glass.png"; ?>" class="navbar_searchglass">
                                    </span>

                                    <input type="text" class="form-control border-0 stages_search" placeholder="Search">
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr>
                    </div>

                    <!-- Stages Collapseable Elements -->
                    <?php foreach ($urban_renewal_terms as $uc_ind => $urban_category) : ?>
                        <?php $urban_renewal_items = $controller->get_urban_renewal_processes($urban_category); ?>
                        <div class="urban_category_accordion_wrapper py-3 py-md-5 <?= $uc_ind > 0 ? "uc_hidden" : ""; ?>" data-process-category="<?= $urban_category->name; ?>" style="<?= $uc_ind > 0 ? "display:none" : ""; ?>">
                            <?php foreach ($urban_renewal_items as $index => $item) : ?>
                                <div class="vstack">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="vstack gap-3">
                                                <div class="hstack align-items-center justify-content-between">
                                                    <div class="fs-3 fw-light opacity-50">
                                                        שלב <?= $index + 1; ?>
                                                    </div>

                                                    <button class="btn p-1 stage_btn rounded-circle collapsed" style="background-color: lightgray" data-bs-toggle="collapse" data-bs-target="#item_<?= $index; ?>">
                                                        <img class="object-fit-cover" style="width: 24px; height: 24px" src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>">
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="fs-2 fw-semibold">
                                                <?= $item->post_title; ?>
                                            </div>

                                            <?php if (!wp_is_mobile() && get_field("paragraph", $item)) : ?>
                                                <div class="fs-6 my-3">
                                                    <?= get_field("paragraph", $item); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-md-5">
                                            <?php if (get_field("displayed_image", $item)) : ?>
                                                <div class="d-flex px-4 py-2 align-items-center justify-content-center">
                                                    <img class="rounded-3 object-fit-cover stage_displayd_image" src="<?= get_field("displayed_image", $item); ?>">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="collapse stages_collapse_wrapper" id="item_<?= $index; ?>">
                                        <?php
                                        $stages_title = get_field("stages_title", $item) ?? null;
                                        $renewal_stages = get_field("renewal_stages", $item) ?? null;
                                        ?>

                                        <?php if (wp_is_mobile() && get_field("paragraph", $item)) : ?>
                                            <div class="fs-6 my-3">
                                                <?= get_field("paragraph", $item); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($stages_title) : ?>
                                            <div class="fs-6 fw-semibold mb-4">
                                                <?= $stages_title; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($renewal_stages && is_array($renewal_stages) && !empty($renewal_stages)) : ?>
                                            <?php foreach ($renewal_stages as $stage_index => $stage) : ?>
                                                <?php
                                                $stage_title = get_field("stage_title", $stage) ?? null;
                                                $stages = get_field("stages", $stage) ?? null;
                                                ?>

                                                <?php if ($stage_title) : ?>
                                                    <div class="stage_accordion_wrapper py-4 px-4 mb-4">
                                                        <div class="hstack align-items-center justify-content-between collapsed stage_accordion" data-bs-toggle="collapse" data-bs-target="#stage_<?= $stage_index; ?>">
                                                            <div class="hstack gap-2 align-items-center">
                                                                <div class="stage_circle"></div>

                                                                <div class="fs-5">
                                                                    <?= $stage_title; ?>
                                                                </div>
                                                            </div>

                                                            <img src="<?= get_template_directory_uri() . "/assets/images/down-arrow.png"; ?>" class="stage_arrow">
                                                        </div>

                                                        <div class="collapse stage_collapable py-2 py-md-4" id="stage_<?= $stage_index; ?>">
                                                            <hr>

                                                            <?php foreach (get_field("stages", $stage) as $e) : ?>
                                                                <?= $controller->get_dynamic_template($e); ?>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <hr class="mt-3 mt-md-5" style="border-width: 4px">
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<?php if ($controller->faq_items && is_array($controller->faq_items) && !empty($controller->faq_items)) : ?>
    <div id="faq_section" class="container-fluid p-md-5 p-3" style="background-image: url(<?= $controller->faq_background_image; ?>); background-size: cover; background-repeat: no-repeat; background-position: center">
        <?php if ($controller->faq_title) : ?>
            <?php if (wp_is_mobile()) : ?>
                <div class="display-4 text-center fw-semibold mb-4">
                    <?= $controller->faq_title; ?>
                </div>
            <?php else : ?>
                <div class="display-4 fw-semibold mb-4 rubik">
                    <?= $controller->faq_title; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="row">
            <!-- FAQs -->
            <div class="col">
                <div class="vstack gap-4">
                    <?php foreach ($controller->faq_items as $idx => $faq) : ?>
                        <div class="vstack rounded-4 py-4 px-3 faq_toggler collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $idx; ?>">
                            <div class="hstack align-items-center justify-content-between">
                                <?php if (get_field("question", $faq)): ?>
                                    <div class="fs-5 fw-semibold">
                                        <?= get_field("question", $faq); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="faq_icon"></div>
                            </div>

                            <div class="collapse my-4" id="collapse_<?= $idx; ?>">
                                <?= get_field("answer", $faq); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- FAQS Side Image -->
            <?php if (!wp_is_mobile() && $controller->faq_side_image) : ?>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center sticky-top">
                        <img src="<?= $controller->faq_side_image; ?>" class="faq_side_image">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- External Links -->
<?php if ($controller->external_links_items && is_array($controller->external_links_items) && !empty($controller->external_links_items)) : ?>
    <div id="external_links_section" class="container-fluid px-md-5 px-3 my-5">
        <?php if ($controller->external_links_title): ?>
            <div class="display-4 fw-semibold mb-2 rubik">
                <?= $controller->external_links_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->external_links_subtitle): ?>
            <div class="fs-6 mb-5">
                <?= $controller->external_links_subtitle; ?>
            </div>
        <?php endif; ?>

        <div class="row row-gap-4">
            <?php foreach ($controller->external_links_items as $idx => $e) : ?>
                <div class="col-md-4">
                    <div class="vstack justify-content-between align-items-center border rounded-4 py-2 px-3 external_links_container">
                        <div class="hstack align-items-center justify-content-between external_links_toggler collapsed" data-bs-toggle="collapse" data-bs-target="#external_collapse_<?= $idx; ?>">
                            <div class="hstack gap-2 align-items-center">
                                <img src="<?= get_field("image", $e); ?>" alt="" class="external_link_image">

                                <div class="fs-6 fw-semibold">
                                    <?= get_field("title", $e); ?>
                                </div>
                            </div>

                            <div class="justify-self-end">
                                <img class="external_link_icon" src="<?= get_template_directory_uri() . "/assets/images/down-arrow.png"; ?>" style="width: 24px; height: 24px">
                            </div>
                        </div>

                        <div class="collapse w-100" id="external_collapse_<?= $idx; ?>">
                            <div class="vstack my-2 gap-3">
                                <?php foreach (get_field("links", $e) as $link) : ?>
                                    <?php if (isset($link["link"])) : ?>
                                        <a class="text-reset text-decoration-none external_link_container" href="<?= $link["link"]; ?>">
                                            <div class="hstack py-3 gap-4 align-items-center justify-content-between">
                                                <img src="<?= get_template_directory_uri() . "/assets/images/link.png"; ?>" style="width: 24px; height: 24px">

                                                <div class="fs-6 fw-semibold">
                                                    <?= $link["label"]; ?>
                                                </div>

                                                <img src="<?= get_template_directory_uri() . "/assets/images/btn-arrow-black.png"; ?>" style="width: 24px; height: 24px">
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Contact Us -->
<div class="container-fluid px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</div>

<?php get_footer(); ?>