<?php

// Template Name: Resident Rights

get_header();

// getting page fields
$main_title = get_field("main_title") ?? null;
$main_paragraph = get_field("main_paragraph") ?? null;
$side_image = get_field("side_image") ?? null;
$side_image_mobile = get_field("side_image_mobile") ?? null;

wp_enqueue_style(
    "resident_rights_css",
    get_template_directory_uri() . "/assets/css/resident-rights.css",
    ["main_css"],
    filemtime(get_template_directory() . "/assets/css/resident-rights.css"),
    "all"
);

wp_enqueue_script(
    "resident_rights_js",
    get_template_directory_uri() . "/assets/js/resident-rights.js",
    [],
    filemtime(get_template_directory() . "/assets/js/resident-rights.js")
);

?>

<!-- Navbar -->
<nav class="container-fluid px-0">
    <!-- Navbar -->
    <?php get_template_part("template-parts/navbar"); ?>
</nav>

<!-- Header -->
<header class="container-fluid px-md-5 px-3 mb-5">
    <!-- Breadcrumbs -->
    <?php if (function_exists("yoast_breadcrumb")) : ?>
        <div class="sq_breadcrumbs mt-5 fs-5 mb-4 mb-md-0">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>

    <div class="row my-3 row-gap-4">
        <!-- Information Column -->
        <div class="col-md-6">
            <div class="vstack gap-3">
                <?php if ($main_title) : ?>
                    <div class="display-3 fw-bold">
                        <?= $main_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($main_paragraph) : ?>
                    <div class="fs-5">
                        <?= $main_paragraph; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Image Column -->
        <div class="col-md-6">
            <?php if (!wp_is_mobile() && $side_image) : ?>
                <div class="d-flex sticky-top align-items-center justify-content-center">
                    <img class="img-fluid" src="<?= $side_image; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>

            <?php if (wp_is_mobile() && $side_image_mobile) : ?>
                <div class="d-flex sticky-top align-items-center justify-content-center">
                    <img class="img-fluid" src="<?= $side_image_mobile; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Main -->
<main class="container-fluid px-md-5 py-5 px-3" id="main_rr_section">
    <?php
    $rights_categories = get_terms([
        "taxonomy" => "resident-rights-category",
        "hide_empty" => true
    ]);
    ?>

    <?php if ($rights_categories  && is_array($rights_categories) && !empty($rights_categories)) : ?>
        <div class="hstack gap-3 flex-wrap align-items-center mb-5" role="tablist">
            <?php foreach ($rights_categories as $index => $right) : ?>
                <button class="btn btn-sq-secondary rounded-pill px-4 <?= $index == 0 ? "active" : ""; ?>" data-bs-toggle="tab" data-bs-target="#<?= $right->term_id; ?>">
                    <?= $right->name; ?>
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <hr>

    <div class="tab-content">
        <?php foreach ($rights_categories as $index => $right) : ?>
            <?php
            $rights = get_posts([
                "post_type" => "resident-right",
                "posts_per_page" => -1,
                "tax_query" => [
                    [
                        "taxonomy" => "resident-rights-category",
                        "field" => "term_id",
                        "terms" => $right->term_id,
                        "operator" => "IN"
                    ]
                ]
            ]);
            ?>

            <div class="tab-pane fade <?= $index == 0 ? "active show" : ""; ?>" id="<?= $right->term_id; ?>">
                <?php
                $list_side_image = get_field("list_side_image") ?? null;
                $right_title = $right->name ?? null;
                $right_desc = $right->description ?? null;
                ?>

                <div class="row">
                    <?php if ($right_title) : ?>
                        <div class="col-md-12">
                            <div class="fs-1 fw-bold mb-2  rubik">
                                <?= $right_title; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($right_desc) : ?>
                        <div class="col-md-6">
                            <div class="fs-6 mb-3">
                                <?= $right_desc; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-7">
                        <div class="vstack gap-4">
                            <?php foreach ($rights as $e) : ?>
                                <div class="vstack rounded-4 px-3 rr_wrapper_collapse">
                                    <div class="hstack align-items-center py-4 justify-content-between rr_trigger_collapse collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $e->ID; ?>">
                                        <?php if ($e->post_title): ?>
                                            <div class="fs-5 fw-semibold">
                                                <?= $e->post_title; ?>
                                            </div>
                                        <?php endif; ?>

                                        <img class="rr_icon" src="<?= get_template_directory_uri() . "/assets/images/down-arrow.png"; ?>" style="width: 24px; height: 24px">
                                    </div>

                                    <div class="collapse rr_element_collapse my-4" id="collapse_<?= $e->ID; ?>">
                                        <?php $content = get_field("flex_content", $e) ?? null; ?>

                                        <?php if ($content && is_array($content) && !empty($content)) : ?>
                                            <?php foreach ($content as $c) : ?>
                                                <?php
                                                $fc_layout = $c["acf_fc_layout"] ?? null;
                                                $value = $c["value"] ?? null;

                                                get_template_part("template-parts/flex-content/{$fc_layout}", null, $value)
                                                ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php if (!wp_is_mobile() && $list_side_image) : ?>
                        <div class="col-md-5">
                            <div class="sticky-top">
                                <div class="d-flex w-100 h-100 align-items-center justify-content-start">
                                    <img src="<?= $list_side_image; ?>" class="article_list_side_image">
                                    <img src="<?= get_template_directory_uri() . "/assets/images/cube.png"; ?>" class="article_list_side_cube">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<section class="container-fluid px-0">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>

<?php get_footer(); ?>