<?php

$area_title = $args['area_title'];
$area_content = $args['area_content'];
$area_image = $args['area_image'];
$sticky = $args['sticky'];
$area_more_btn = $args['area_more_btn'];
$all_fields=$args['all_fields'];
?>

<div class="fw-bold fs-3"><?= $area_title; ?></div>

<div class="container">
    <div class="row">
        <?php if ($area_content) : ?>
            <div class="col-lg-8 col-sm-12">
                <div class="GroupContent"><?= $area_content; ?></div>
            </div>
        <?php endif; ?>

        <?php if ($area_image) : ?>
            <div class="col-lg-4 col-sm-12 position-relative">
                <img src="<?= $area_image; ?>" loading="lazy" <?= $sticky; ?> />
            </div>
        <?php endif; ?>
    </div>

    <?php if ($area_more_btn && is_array($area_more_btn)) : ?>
        <a
            class="sq-tertiary-button text-decoration-none"
            style="background:transparent;"
            href="<?= $area_more_btn["url"] ?? "#"; ?>"
            target="<?= $area_more_btn["target"] ?? ""; ?>"
        >
            <?= $area_more_btn["title"]; ?>
        </a>
    <?php endif; ?>
</div>