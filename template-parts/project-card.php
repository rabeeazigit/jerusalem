<?php
$project_name = $args["project_name"] ?? null;
$project_address = $args["project_address"] ?? null;
$project_link = $args["project_link"] ?? "#";
$project_neighborhood = $args["project_neighborhood"] ?? null;
$project_status = $args["project_status"] ?? null;
$project_card_image = $args["project_card_image"] ?? null;
// print_r($project_status);
?>

<a href="<?= $project_link; ?>" class="text-reset text-decoration-none vstack project_card_wrapper px-3 gap-2">
    <div class="d-flex align-items-start justify-content-start project_card_image" style="background-image: url(<?= $project_card_image; ?>);">
        <?php if ($project_status && !empty($project_status)) : ?>
            <div class="hstack gap-2 align-items-start project_status_wrapper">
                <?php
                $status_color = get_field("project_status_color", $project_status);
                $status_name = $project_status->name;
                // print_r($status_name);
                // print_r($status_color);
                ?>

                <?php if ($status_color) : ?>
                    <div class="project_status_color" style="background-color: <?= $status_color; ?>;"></div>
                <?php endif; ?>

                <?php if ($status_name) : ?>
                    <div class="fs-6">
                        <?= $status_name; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="vstack gap-1">
        <?php if ($project_name) : ?>
            <div class="fs-5 fw-bold ">
                <?= $project_name; ?>
            </div>
        <?php endif; ?>

        <?php if ($project_neighborhood) : ?>
            <div class="hstack px-2 align-items-center gap-3 opacity-75">
                <div class="rubik">
                    <?= $project_neighborhood->post_title; ?>
                </div>

                <?php if ($project_address) : ?>
                    <div class="vr"></div>

                    <div class="rubik">
                        <?= $project_address; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</a>