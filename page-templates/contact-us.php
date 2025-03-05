<?php

// Template Name: Contact Us

$ctrl = new ContactUs();

get_header();
?>

<header class="container-fluid px-0 text-light">
    <div class="linear_bg_page">
        <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>

        <div class="py-5 px-3 px-md-5">
            <?php if (function_exists("yoast_breadcrumb")) : ?>
                <div class="sq_breadcrumbs fs-5">
                    <?php yoast_breadcrumb(); ?>
                </div>
            <?php endif; ?>

            <div class="row row-gap-3">
                <div class="col-12 col-xl-6">
                    <div class="vstack gap-2 mb-2">
                        <?php if ($ctrl->main_title) : ?>
                            <div class="display-4 fw-bold">
                                <?= $ctrl->main_title; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($ctrl->main_subtitle) : ?>
                            <div class="fs-5">
                                <?= $ctrl->main_subtitle; ?>
                            </div>
                        <?php endif; ?>

                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="vstack gap-3">
                                <?php if ($ctrl->footer_contact_title) : ?>
                                    <div class="fs-5 fw-bold">
                                        <?= $ctrl->footer_contact_title; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($ctrl->footer_contact_information_row && is_array($ctrl->footer_contact_information_row) && !empty($ctrl->footer_contact_information_row)) : ?>
                                    <div class="row row-gap-3">
                                        <?php foreach ($ctrl->footer_contact_information_row as $info_row) : ?>
                                            <?php
                                            $label = $info_row["label"] ?? null;
                                            $value_type = $info_row["value_type"] ?? null;
                                            $paragraph = $info_row["paragraph"] ?? null;
                                            $whatsapp_value = $info_row["whatsapp_value"] ?? null;
                                            $email_value = $info_row["email_value"] ?? null;

                                            if (strtolower($value_type) == "paragraph") {
                                                $value_to_display = $paragraph;
                                            } else if (strtolower($value_type) == "whatsapp") {
                                                $value_to_display = $whatsapp_value;
                                            } else if (strtolower($value_type) == "email") {
                                                $value_to_display = $email_value;
                                            } else {
                                                $value_to_display = null;
                                            }
                                            ?>
                                            <div class="col-4">
                                                <?php if ($label) : ?>
                                                    <div class="fs-6 fw-bold">
                                                        <?= $label; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-8">
                                                <?php if (strtolower($value_type) == "paragraph") : ?>
                                                    <div class="fs-6">
                                                        <?= $paragraph; ?>
                                                    </div>
                                                <?php elseif (strtolower($value_type) == "whatsapp") : ?>
                                                    <a href="https://wa.me/<?= $whatsapp_value; ?>" target="_blank" class="fs-6 text-reset">
                                                        <?= $whatsapp_value; ?>
                                                    </a>
                                                <?php elseif (strtolower($value_type) == "email") : ?>
                                                    <a href="mailto: <?= $email_value; ?>" target="_blank" class="fs-6 text-reset">
                                                        <?= $email_value; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!wp_is_mobile()) : ?>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-start">
                                    <img src="<?= $ctrl->side_image; ?>" class="rounded-circle object-fit-cover" style="height: 180px; width: 180px">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="p-4 bg-white rounded-4">
                        <div class="d-flex justify-content-md-start justify-content-center">
                            <div class="hstack contact-form-tablist align-items-center rounded-pill p-1 mb-3" role="tablist">
                                <button class="rounded-pill py-2 fs-5 px-4 btn contact-form-tab active" data-bs-toggle="tab" data-bs-target="#resident-form" role="tab">
                                    אני תושב
                                </button>

                                <button class="rounded-pill py-2 fs-5 px-4 btn contact-form-tab" data-bs-toggle="tab" data-bs-target="#entre-form" role="tab">
                                    אני יזם
                                </button>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="resident-form">
                                <?= do_shortcode('[contact-form-7 title="Contact Us - Resident"]'); ?>
                            </div>

                            <div class="tab-pane fade" id="entre-form">
                                <?= do_shortcode('[contact-form-7 title="Contact Us - Entrepreneur"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    $("button[type=submit] br").remove();

    $(".contact_us_btn").addClass("disabled");
</script>

<?php get_footer(); ?>