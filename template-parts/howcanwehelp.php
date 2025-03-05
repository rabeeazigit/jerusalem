<?php
$hwch_image = get_field("hwch_image", "options");
$hwch_title = get_field("hwch_title", "options");
$hwch_text = get_field("hwch_text", "options");
$hcwh_link = get_field("hcwh_link", "options");
?>

<div class="d-lg-block d-none">
    <div class="container-fluid howcanwehelp" style="background:url('<?php echo get_template_directory_uri(); ?>/assets/images/about/bk1.png');">
        <div class="row align-items-center p-5">
            <?php if ($hwch_image) : ?>
                <div class="col align-items-center text-center">
                    <img src="<?php echo $hwch_image; ?>" loading="lazy" />
                </div>
            <?php endif; ?>

            <div class="col align-items-center">
                <?php if ($hwch_title) : ?>
                    <div class="h1 hcwhy-h">
                        <?php echo $hwch_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($hwch_text) : ?>
                    <div class="hcwhy-p rubik">
                        <?php echo $hwch_text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($hcwh_link && is_array($hcwh_link)) : ?>
                    <a href="<?php echo $hcwh_link['url']; ?>" class="text-decoration-none tertiary_button_trans">
                        <?php echo $hcwh_link['title'] ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="d-block d-lg-none">
    <div class="container-fluid px-0 howcanwehelp" style="background:url('<?php echo get_template_directory_uri(); ?>/assets/images/about/bk1.png');">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="align-items-center justify-content-center vstack px-5 py-4">
                    <?php if ($hwch_title) : ?>
                        <div class="fw-bold fs-1">
                            <?php echo $hwch_title; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($hwch_text) : ?>
                        <div class="hcwhy-p rubik text-center">
                            <?php echo $hwch_text; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($hcwh_link && is_array($hcwh_link)) : ?>
                        <a href="<?php echo $hcwh_link['url']; ?>" class="text-decoration-none tertiary_button_trans">
                            <?php echo $hcwh_link['title'] ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($hwch_image) : ?>
                <div class="col-12">
                    <div class="w-100">
                        <img src="<?= $hwch_image; ?>" loading="lazy" class=" w-100" style="object-position: center;">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>