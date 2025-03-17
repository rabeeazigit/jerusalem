<?php

// Template Name: Resident Info

get_header(); ?>

<?php get_template_part("template-parts/navbar"); ?>

<?php
$controller = new ResidentInfo();

// Setting up renewual items
$urban_renewal_terms = $controller->get_renewal_categories();
$urban_renewal_items = [];
$stages_page = get_page_by_template("page-templates/urban-renewal-process.php");

if ($urban_renewal_terms && is_array($urban_renewal_terms) && !empty($urban_renewal_terms)) {
    foreach ($urban_renewal_terms as $term) {
        $urban_renewal_items[$term->name] = $controller->get_urban_renewal_processes($term);
    }
}

// Settings up resident rights
$resident_rights = $controller->get_resident_rights();

?>

<!-- Hero -->
<div class="container-fluid px-md-5 px-3 resident_info_head_wrapper">
    <div class="row py-md-5 pt-5 row-gap-4">
        <div class="col-md-6">
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

                <?php if ($controller->hero_description) : ?>
                    <div class="fs-5">
                        <?= $controller->hero_description; ?>
                    </div>
                <?php endif; ?>

                <div class="hstack anchor_tags_container gap-3 flex-wrap">
                    <?php if ($urban_renewal_items && is_array($urban_renewal_items) && !empty($urban_renewal_items)) : ?>
                        <div class="">
                            <a href="#urban_renewal_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->urban_renewal_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($resident_rights && is_array($resident_rights) && !empty($resident_rights)) : ?>
                        <div class="">
                            <a href="#resident_rights_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->resident_rights_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($controller->faq_items && is_array($controller->faq_items) && !empty($controller->faq_items)) : ?>
                        <div class="">
                            <a href="#faq_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->faq_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($controller->event_slider_items && is_array($controller->event_slider_items) && !empty($controller->event_slider_items)) : ?>
                        <div class="">
                            <a href="#event_slider_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->event_slider_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($controller->downloadable_files_title) : ?>
                        <div class="">
                            <a href="#downloads_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->downloadable_files_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if ($controller->external_links_items && is_array($controller->external_links_items) && !empty($controller->external_links_items)) : ?>
                        <div class="">
                            <a href="#external_links_section" class="btn btn-sq-ghost fs-5 text-decoration-none rounded-pill text-reset">
                                <?= $controller->external_links_title; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <?php if (!wp_is_mobile() && $controller->hero_side_image) : ?>
                <div class="d-flex sticky-top align-items-center justify-content-center">
                    <img class="rosh-ha-aer-sideimage" src="<?= $controller->hero_side_image; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>

            <?php if (wp_is_mobile() && $controller->hero_side_image_mobile) : ?>
                <div class="d-flex align-items-center justify-content-center">
                    <img class="rosh-ha-aer-sideimage" src="<?= $controller->hero_side_image_mobile; ?>" alt="" loading="lazy">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Urban Renewal -->
<?php if ($urban_renewal_items && is_array($urban_renewal_items) && !empty($urban_renewal_items)) : ?>
    <div class="container-fluid py-5 mb-4" style="background-color: #174A75;" id="urban_renewal_section">
        <?php if ($controller->urban_renewal_title) : ?>
            <div class="display-5 text-center text-white fw-semibold mb-4 rubik">
                <?= $controller->urban_renewal_title; ?>
            </div>
        <?php endif; ?>

        <!-- Category Toggle -->
        <div class="hstack w-100 justify-content-md-start justify-content-center align-items-center">
            <div class="hstack align-items-center border rounded-pill p-1 mb-3" style="width: fit-content;" role="tablist">
                <?php foreach ($urban_renewal_terms as $i => $category) : ?>
                    <button class="btn btn-sq-primary rounded-pill fs-5 <?= $i == 0 ? "active" : ""; ?>" data-bs-toggle="tab" data-bs-target="#tab_<?= $i; ?>">
                        <?= $category->name; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Accordions Column -->
            <div class="col-md-5">
                <?php if ($urban_renewal_items && is_array($urban_renewal_items) && !empty($urban_renewal_items)) : ?>
                    <?php $category_index = 0; ?>
                    <div class="tab-content">
                        <?php foreach ($urban_renewal_items as $category => $items) : ?>
                            <div class="tab-pane fade" role="tabpanel" id="tab_<?= $category_index++; ?>">
                                <div class="vstack gap-4">
                                    <?php foreach ($items as $item_index => $item) : ?>
                                        <a href="<?= get_permalink($stages_page); ?>" class="text-reset text-decoration-none hstack align-items-start justify-content-between border rounded-4 p-3 resident_accordion" data-image="<?= get_field("card_image", $item); ?>">
                                            <div class="hstack gap-3 align-items-center justify-content-start">
                                                <div class="fs-1 text-white opacity-75">
                                                    <?= $item_index + 1 < 10 ? "0" . ($item_index + 1) : $item_index + 1 ?>
                                                </div>

                                                <div class="vstack gap-1">
                                                    <div class="fs-5 text-white fw-semibold">
                                                        <?= get_field("card_display_name", $item); ?>
                                                    </div>

                                                    <div class="fs-6 text-white opacity-75">
                                                        <?= get_field("card_subtitle", $item); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <img class="resident_info_row_arrow" src="<?= get_template_directory_uri() . "/assets/images/yellow-arrow-left.png"; ?>" style="width: 24px; height: 24px">
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Image Column -->
            <?php if (!wp_is_mobile()) : ?>
                <div class="col-md-7">
                    <div class="d-flex sticky-top justify-content-center">
                        <img src="" alt="" class="rounded-5 resident_side_image">
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Link -->
        <?php if ($controller->urban_renewal_link) : ?>
            <div class="d-flex justify-content-md-start justify-content-center align-items-center">
                <a href="<?= $controller->urban_renewal_link["url"]; ?>" target="<?= $controller->urban_renewal_link["target"]; ?>" class="text-decoration-none fs-5 sq-primary-button">
                    <?= $controller->urban_renewal_link["title"]; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Residents Rights -->
<?php if ($resident_rights && is_array($resident_rights) && !empty($resident_rights)) : ?>
    <div id="resident_rights_section" class="container" style="background-image: url(<?= ""; ?>); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <?php if ($controller->resident_rights_title) : ?>
            <div class="text-center display-4 rubik fw-semibold mb-3">
                <?= $controller->resident_rights_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->resident_rights_link) : ?>
            <div class="d-flex justify-content-center align-items-center mb-4">
                <a href="<?= $controller->resident_rights_link["url"]; ?>" target="<?= $controller->resident_rights_link["target"]; ?>" class="text-decoration-none fs-5 sq-primary-button">
                    <?= $controller->resident_rights_link["title"]; ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="row row-gap-4 justify-content-center">
            <?php foreach ($resident_rights as $e) : ?>
                <div class="col-md-3">
                    <div class="vstack h-100 align-items-start justify-content-between border rounded-5 p-4 mb-5 bg-white">
                        <div>
                            <div class="fs-3 fw-bold mb-3">
                                <?= $e->name; ?>
                            </div>

                            <div class="fs-6">
                                <?= get_field("description", $e); ?>
                            </div>
                        </div>

                        <div class="vstack align-items-start justify-content-end">
                            <a href="<?= get_permalink($e); ?>" class="text-decoration-none fs-5 sq-tertiary-button">
                                <?= get_field("link_text", $e); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- FAQ -->
<?php if ($controller->faq_items && is_array($controller->faq_items) && !empty($controller->faq_items)) : ?>
    <div id="faq_section" class="container-fluid my-4 p-md-5 p-3" style="background-image: url(<?= $controller->faq_background_image; ?>); background-size: cover; background-repeat: no-repeat; background-position: center">
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
                        <?php $hidden = $idx > 6 ? 'style="display: none"' : ''; ?>

                        <div <?= $hidden; ?> class="faq-wrapper">
                            <div class="vstack rounded-4 faq_toggler_wrapper">
                                <div 
                                    class="hstack align-items-center py-4 px-3 justify-content-between faq_toggler collapsed"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse_<?= $idx; ?>"
                                >
                                    <?php if (get_field("question", $faq)): ?>
                                        <div class="fs-5 fw-semibold">
                                            <?= get_field("question", $faq); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="faq_icon"></div>
                                </div>

                                <div class="collapse my-4 px-3" id="collapse_<?= $idx; ?>">
                                    <?= get_field("answer", $faq); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($controller->faq_items) > 6) : ?>
                    <button class="btn btn-sm btn-sq-tertiary rounded-pill mt-4" id="load-more-faq">
                        טען עוד
                        
                        <span>
                            (<span id="more-faq-count"><?= count($controller->faq_items) - 7; ?></span>)
                        </span>
                    </button>
                <?php endif; ?>
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

<!-- אירועים וקורבים Slider -->
<?php if ($controller->event_slider_items && is_array($controller->event_slider_items) && !empty($controller->event_slider_items)) : ?>
    <div id="event_slider_section" class="container-fluid pt-5 pb-3 my-5">
        <?php get_template_part("template-parts/events-courses-slider", null, [
            "events_courses_title" => $controller->event_slider_title,
            "events_and_courses_paragraph" => $controller->event_slider_description,
            "events_and_courses_link" => $controller->event_slider_link,
            "events_and_courses_items" => $controller->event_slider_items,
        ]); ?>
    </div>
<?php endif; ?>

<!-- Downloadable Files -->
<div id="downloads_section" class="container-fluid p-md-5 p-3 my-4" style="background-color: #EBE8E3;">
    <?php if ($controller->downloadable_files_title) : ?>
        <?php if (wp_is_mobile()) : ?>
            <div class="display-4 text-center fw-semibold mb-2">
                <?= $controller->downloadable_files_title; ?>
            </div>
        <?php else : ?>
            <div class="display-4 fw-semibold mb-2 rubik">
                <?= $controller->downloadable_files_title; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($controller->downloadable_files_subtitle) : ?>
        <?php if (wp_is_mobile()) : ?>
            <div class="fs-6 text-center mb-4">
                <?= $controller->downloadable_files_subtitle; ?>
            </div>
        <?php else : ?>
            <div class="fs-6 mb-4">
                <?= $controller->downloadable_files_subtitle; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($controller->file_categories_to_show && is_array($controller->file_categories_to_show) && !empty($controller->file_categories_to_show)) : ?>
        <?php if (!wp_is_mobile()) : ?>
            <div class="hstack align-items-center justify-content-start gap-3" role="tablist">
                <?php foreach ($controller->file_categories_to_show as $idx => $file_category) : ?>
                    <button class="btn btn-sq-secondary rounded-pill px-4 <?= $idx == 0 ? "active show" : ""; ?>" data-bs-toggle="tab" data-bs-target="#file_tab_<?= $file_category->term_id; ?>">
                        <?= $file_category->name; ?>
                    </button>
                <?php endforeach; ?>

                <div class="input-group rounded-pill overflow-hidden ">
                    <span class="input-group-text border-none" style=" background-color: white">
                        <img src="<?= get_template_directory_uri() . "/assets/images/search-glass.png"; ?>" class="navbar_searchglass">
                    </span>

                    <input type="text" class="form-control border-0 downloadable_file_search" placeholder="Search">
                </div>
            </div>
        <?php else : ?>
            <div class="vstack" role="tablist">
                <div class="input-group rounded-pill overflow-hidden">
                    <span class="input-group-text border-none" style=" background-color: white">
                        <img src="<?= get_template_directory_uri() . "/assets/images/search-glass.png"; ?>" class="navbar_searchglass">
                    </span>

                    <input type="text" class="form-control border-0 downloadable_file_search" placeholder="Search">
                </div>

                <div class="hstack gap-4 overflow-auto py-3 my-3">
                    <?php foreach ($controller->file_categories_to_show as $idx => $file_category) : ?>
                        <button style="white-space: nowrap" class="btn btn-sq-secondary rounded-pill px-4 <?= $idx == 0 ? "active show" : ""; ?>" data-bs-toggle="tab" data-bs-target="#file_tab_<?= $file_category->term_id; ?>" style="width: fit-content">
                            <?= $file_category->name; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="tab-content">
        <?php foreach ($controller->file_categories_to_show as $idx => $file_category) : ?>
            <?php $files = $controller->get_files_by_category($file_category); ?>

            <div class="tab-pane fade <?= $idx == 0 ? "active show" : ""; ?>" role="tabpanel" id="file_tab_<?= $file_category->term_id; ?>">
                <div class="row row-gap-4 my-5">
                    <?php foreach ($files as $e) : ?>
                        <?php
                        $file_link = "";
                        if (get_field("is_external_file", $e)) {
                            $file_link = get_field("file_url", $e);
                        } else {
                            $file_link = get_field("file", $e);
                        }
                        ?>
                        <div class="col-md-3">
                            <a data-search="<?= (get_field("short_description", $e) ?? "") . "," . (get_field("display_name", $e)); ?>" download target="_blank" href="<?= $file_link; ?>" class="text-decoration-none text-reset hstack gap-2 align-items-center downloadable_file_item rounded-4 p-3">
                                <img src="<?= get_template_directory_uri() . "/assets/images/doc.png"; ?>" style="width: 32px; height: 32px; align-self: flex-start">

                                <div class="vstack gap-2">
                                    <div class="fs-5 fw-bold">
                                        <?= get_field("display_name", $e); ?>
                                    </div>

                                    <div class="fs-6">
                                        <?= truncate_sentence(get_field("short_description", $e) ?? "", 80); ?>
                                    </div>
                                </div>

                                <img src="<?= get_template_directory_uri() . "/assets/images/download.png"; ?>" style="width: 32px; height: 32px; align-self: flex-end">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

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