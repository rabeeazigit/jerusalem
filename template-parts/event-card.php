<?php
$event_name = $args["event_name"] ?? null;
$event_occurrence_date = $args["event_occurrence_date"] ?? null;
$event_place = $args["event_place"] ?? null;
$event_card_image = $args["event_card_image"] ?? null;
$event_card_short_description = $args["event_card_short_description"] ?? null;
$event_card_short_button_text = $args["event_card_short_button_text"] ?? null;
$permalink = $args["permalink"] ?? "#";
$post_type = $args["post_type"] ?? null;

switch ($post_type) {
    case "event":
        $post_type = "כנס";
        break;
    case "forum":
        $post_type = "פורום";
        break;
    case "course":
        $post_type = "קורס";
        break;
}
?>

<div class="vstack event_card_wrapper px-3 gap-2">
    <div class="d-flex align-items-start justify-content-start event_card_image" style="background-image: url(<?= $event_card_image; ?>);">
        <div class="hstack gap-2 align-items-start event_status_wrapper">
            <?php if ($post_type) : ?>
                <div class="fs-6">
                    <?= $post_type; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="vstack align-items-start gap-1">
        <?php if ($event_name) : ?>
            <div class="fs-5 fw-bold">
                <?= $event_name; ?>
            </div>
        <?php endif; ?>

        <div class="hstack px-2 align-items-center gap-3 opacity-75">
            <?php if ($event_occurrence_date) : ?>
                <div>
                    <?= $event_occurrence_date; ?>
                </div>

                <div class="vr"></div>
            <?php endif; ?>

            <?php if ($event_place) : ?>
                <div>
                    <?= $event_place; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($event_card_short_description) : ?>
            <div class="fs-6 opacity-75">
                <?= $event_card_short_description; ?>
            </div>
        <?php endif; ?>

        <?php if ($event_card_short_button_text) : ?>
            <a href="<?= $permalink; ?>" class="text-decoration-none sq-tertiary-button">
                <?= $event_card_short_button_text; ?>
            </a>
        <?php endif; ?>
    </div>
</div>