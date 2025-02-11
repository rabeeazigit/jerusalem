<?php

// Template Name: Urban Renewal Process

get_header();
?>

<?php
$controller = new UrbanRenewal();

// Setting up renewual items
$urban_renewal_terms = $controller->get_renewal_categories();
$urban_renewal_grouped_items = $controller->get_urban_renewal_processes_grouped_by_stages();
$urban_renewal_items = $controller->get_urban_renewal_processes();
?>

<!-- COLORED HERO -->
<div class="container-fluid py-5 text-light" style="background-color: #174A75;">
    <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>

    <div class="container-fluid px-md-5 px-3 my-5">
        <div class="vstack gap-3">
            <?php if (function_exists("yoast_breadcrumb")) : ?>
                <div class="sq_breadcrumbs fs-5">
                    <?php yoast_breadcrumb(); ?>
                </div>
            <?php endif; ?>

            <?php if ($controller->hero_title) : ?>
                <div class="display-3 fw-bold">
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
                    <div class="vstack">
                        <div class="fs-6">
                            עוד בעמוד
                        </div>

                        <div class="hstack gap-4">
                            <a href="#urban_renewal_process_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill">
                                תהליך התחדשות עירונית
                            </a>

                            <a href="#faq_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill">
                                שאלות נפוצות
                            </a>

                            <a href="#external_links_section" class="btn text-white text-decoration-none btn-sq-ghost rounded-pill">
                                קישורים חיצוניים
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Main Row And Columns -->
    <div class="row text-dark">
        <div class="col-md-4">
            <div class="rounded-4 bg-white p-4">
                <!-- Stage Selector -->
                <div class="hstack align-items-center justify-content-between">
                    <div class="fs-6 fw-semibold">
                        שלבים
                    </div>

                    <div class="hstack align-items-center border rounded-pill p-1" style="width: fit-content;" role="tablist">
                        <?php foreach ($urban_renewal_terms as $i => $category) : ?>
                            <button class="btn btn-sq-primary text-dark rounded-pill fs-6 <?= $i == 0 ? "active" : ""; ?>" data-bs-toggle="tab" data-bs-target="#tab_<?= $i; ?>">
                                <?= $category->name; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <hr>

                <!-- Stages -->
                <?php if ($urban_renewal_grouped_items && is_array($urban_renewal_grouped_items) && !empty($urban_renewal_grouped_items)) : ?>
                    <?php foreach ($urban_renewal_grouped_items as $stage => $proccesses) : ?>
                        <div class="vstack gap-2 mb-3">
                            <div class="row px-0 rounded-4 border">
                                <div class="col-md-1" style="background-color: #EBE8E3">
                                    <div class="d-flex text-center align-items-center justify-content-center h-100 fw-semibold">
                                        <?= $stage; ?>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="vstack gap-2">
                                        <?php foreach ($proccesses as $index => $process) : ?>
                                            <div class="hstack align-items-center justify-content-between p-3">
                                                <div class="hstack fs-5 gap-3">
                                                    <?= ($index + 1 < 10) ? ("0" . $index + 1) : ($index + 1); ?>

                                                    <div class="vr"></div>

                                                    <div class="fs-6 fw-semibold">
                                                        <?= $process->post_title; ?>
                                                    </div>
                                                </div>

                                                <img class="stage_side_arrows" src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>" />
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-8">
            <div class="rounded-4 bg-white p-4">
                <?php foreach ($urban_renewal_items as $index => $item) : ?>
                    <div class="vstack">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="vstack gap-3">
                                    <div class="hstack align-items-center justify-content-between">
                                        <div class="fs-2 fw-light opacity-50">
                                            שלב <?= $index + 1; ?>
                                        </div>

                                        <button class="btn p-1 stage_btn rounded-circle collapsed" style="background-color: lightgray" data-bs-toggle="collapse" data-bs-target="#item_<?= $index; ?>">
                                            <img class="object-fit-cover" style="width: 24px; height: 24px" src="<?= get_template_directory_uri() . "/assets/images/arrow-down.png"; ?>">
                                        </button>
                                    </div>
                                </div>

                                <div class="fs-1 fw-semibold">
                                    <?= $item->post_title; ?>
                                </div>

                                <?php if (get_field("paragraph", $item)) : ?>
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

                        <div class="collapse px-5" id="item_<?= $index; ?>">
                            <?php foreach (get_field("stages", $item) as $e) : ?>
                                <?= $controller->get_dynamic_template($e); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <hr style="border-width: 4px">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<pre>
    <?php print_r($controller->get_urban_renewal_processes_grouped_by_stages()); ?>
</pre>

<!-- FAQ -->
<?php if ($controller->faq_items && is_array($controller->faq_items) && !empty($controller->faq_items)) : ?>
    <div id="faq_section" class="container-fluid p-md-5 p-3" style="background-image: url(<?= $controller->faq_background_image; ?>); background-size: cover; background-repeat: no-repeat; background-position: center">
        <?php if ($controller->faq_title) : ?>
            <?php if (wp_is_mobile()) : ?>
                <div class="display-4 text-center fw-semibold mb-4">
                    <?= $controller->faq_title; ?>
                </div>
            <?php else : ?>
                <div class="display-4 fw-semibold mb-4">
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
            <div class="display-4 fw-semibold mb-2">
                <?= $controller->external_links_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->external_links_subtitle): ?>
            <div class="fs-6">
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