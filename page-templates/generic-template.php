<?php

// Template Name: תבנית גינרי

get_header();
?>

<?php
// Initialize controller class with all properties
// The class loads css styles for this specific template
$controller = new GenericTemplate();
?>

<?php get_template_part("template-parts/navbar"); ?>

<div class="container-fluid px-md-5  px-3">
    <?php if (function_exists("yoast_breadcrumb")) : ?>
        <div class="sq_breadcrumbs mt-5 fs-5 mb-4 mb-md-0">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>

    <div class="row my-3 row-gap-4">
        <div class="col-md-6">
            <div class="vstack gap-3">
                <?php if ($controller->page_title) : ?>
                    <div class="display-3 fw-bold rubik">
                        <?= $controller->page_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($controller->page_content) : ?>
                    <div class="fs-5">
                        <?= $controller->page_content; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <?php if (!wp_is_mobile() && $controller->side_image) : ?>
                <div class="d-flex sticky-top align-items-center justify-content-center">
                    <img class="generic-template-sideimage rounded-5" src="<?= $controller->side_image; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>

            <?php if (wp_is_mobile() && $controller->mobile_side_image) : ?>
                <div class="d-flex sticky-top align-items-center justify-content-center">
                    <img class="generic-template-sideimage" src="<?= $controller->mobile_side_image; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($controller->flex_content) : ?>
    <div class="container-fluid px-md-5 py-5 px-3 <?= $controller->show_flex_content_bg ? "generic-flex-content-wrapper" : ""; ?>">
        <?= $controller->flex_content; ?>
    </div>
<?php endif; ?>

<div class="container-fluid px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</div>

<?php get_footer(); ?>