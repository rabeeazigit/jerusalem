<?php
$image = $args["image"] ?? null;
$paragraph = $args["paragraph"] ?? null;
$read_more_link = $args["read_more_link"] ?? null;
?>

<div class="row mb-4">
    <div class="col-md-7">
        <?php if ($paragraph) : ?>
            <div class="mb-4">
                <?= $paragraph; ?>
            </div>
        <?php endif; ?>

        <?php if ($read_more_link) : ?>
            <a href="<?= $read_more_link["url"]; ?>" class="btn sq-tertiary-button text-reset-text-decoration-none">
                <?= $read_more_link["title"]; ?>
            </a>
        <?php endif; ?>
    </div>

    <div class="col-md-5">
        <?php if ($image) : ?>
            <div class="sticky-top p-5">
                <img src="<?= $image; ?>" class="rounded-4 stage_paragraph_side_image">
            </div>
        <?php endif; ?>
    </div>
</div>