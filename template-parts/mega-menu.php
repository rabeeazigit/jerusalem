<?php
$label = $args["label"] ?? null;
$menu_cards = $args["menu_cards"] ?? null;
$menu_links = $args["menu_links"] ?? null;
?>

<div class="dropdown-center">
    <button
        class="dropdown-toggle mega_menu_toggle main_nav_item fs-5"
        type="button"
        data-bs-toggle="dropdown"
        data-bs-auto-close="outside"
    >
        <?= $label; ?>
    </button>

    <div class="dropdown-menu main_menu_dropdown z-1">
        <div class="row p-4 w-100">
            <div class="col-md-9">
                <?php if ($menu_cards) : ?>
                    <div class="row">
                        <?php foreach ($menu_cards as $e) : ?>
                            <div class="col">
                                <div class="vstack h-100 justify-content-between align-items-start mega_menu_tile">
                                    <?php if ($e["image"]) : ?>
                                        <img src="<?= $e["image"]; ?>" class="main_menu_card_image mb-4">
                                    <?php endif; ?>

                                    <?php if ($e["title"]) : ?>
                                        <div class="fw-bold fs-4 mb-2">
                                            <?= $e["title"]; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($e["paragraph"]) : ?>
                                        <div class="fs-6">
                                            <?= $e["paragraph"]; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($e["link"]) : ?>
                                        <a href="<?= $e["link"]["url"]; ?>" class="text-decoration-none sq-tertiary-button fs-6" target="<?= $e["link"]["target"]; ?>">
                                            <?= $e["link"]["title"]; ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-md-3">
                <div class="vstack gap-2">
                    <?php foreach ($menu_links as $e) : ?>
                        <a href="<?= $e["link"]; ?>" class="dropdown-item vstack gap-1 mega_menu_side_link">
                            <div class="hstack justify-content-between align-items-end">
                                <div class="fs-6 fw-bold rubik">
                                    <?= $e["label"]; ?>
                                </div>

                                <img src="<?= get_template_directory_uri() . "/assets/images/left-arrow.png"; ?>" class="navbar_menu_arrow">
                            </div>

                            <?php if ($e["sub_label"]) : ?>
                                <div class="fs-6">
                                    <?= $e["sub_label"]; ?>
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>