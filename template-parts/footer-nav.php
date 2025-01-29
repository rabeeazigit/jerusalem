<?php
$footer_logos_gallery = get_field("footer_logos_gallery", "options") ?? null;
$footer_brand_logo = get_field("footer_brand_logo", "options") ?? null;
$footer_menus = get_field("footer_menus", "options") ?? null;
$footer_menus = get_field("footer_menus", "options") ?? null;
$social_media_links = get_field("social_media_links", "options") ?? null;
$footer_contact_title = get_field("footer_contact_title", "options") ?? null;
$footer_contact_information_row = get_field("footer_contact_information_row", "options") ?? null;
$footer_copyright_text = get_field("footer_copyright_text", "options") ?? null;
?>

<div class="hstack py-4 gap-5 justify-content-center align-items-center">
    <?php if ($footer_logos_gallery && is_array($footer_logos_gallery) && !empty($footer_logos_gallery)) : ?>
        <?php foreach ($footer_logos_gallery as $e) : ?>
            <img src="<?= $e; ?>" class="footer_gallery_logo object-fit-cover">
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<hr>

<div class="row gx-5 pt-5 pb-4">
    <div class="col-md-2">
        <?php if ($social_media_links) : ?>
            <div class="vstack">
                <?php if ($footer_brand_logo) : ?>
                    <img src="<?= $footer_brand_logo; ?>" class="footer_brand_logo">
                <?php endif; ?>

                <hr>

                <?php if ($social_media_links && is_array($social_media_links) && count($social_media_links) > 0) : ?>
                    <div class="hstack gap-2 align-items-center">
                        <?php foreach ($social_media_links as $e) : ?>
                            <a href="<?= $e["link"]["url"] ?? "#"; ?>" target="<?= $e["link"]["target"] ?? ""; ?>" title="<?= $e["link"]["title"] ?? ""; ?>" class="text-reset text-decoration-none">
                                <?php if ($e["icon"]) : ?>
                                    <img src="<?= $e["icon"]; ?>" alt="<?= $e["link"]["title"] ?? ""; ?>" class="navbar_social_icon">
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($footer_menus && is_array($footer_menus) && !empty($footer_menus)) : ?>
        <div class="col-md-7">
            <div class="hstack justify-content-center">
                <?php foreach ($footer_menus as $menu) : ?>
                    <?php
                    $menu_label = $menu["menu_title"] ?? null;
                    $menu_items_whole = $menu["menu_items"] ?? [];
                    $menu_items = array_map(function ($sub_menu) {
                        return [
                            "menu_link" => $sub_menu["menu_link"] ?? null,
                            "menu_icon" => $sub_menu["menu_icon"] ?? null,
                        ];
                    }, $menu_items_whole);
                    ?>

                    <?php if ($menu_items && is_array($menu_items) && !empty($menu_items)) : ?>
                        <div class="vstack align-items-start gap-3">
                            <?php if ($menu_label) : ?>
                                <div class="fs-5 fw-bold">
                                    <?= $menu_label; ?>
                                </div>

                                <?php foreach ($menu_items as $menu_item) : ?>
                                    <?php if (is_array($menu_item["menu_link"])) : ?>
                                        <a href="<?= $menu_item["menu_link"]["url"]; ?>" target="<?= $menu_item["menu_link"]["target"]; ?>" class="fs-6 text-decoration-none text-reset">
                                            <?php if ($menu_item["menu_icon"]) : ?>
                                                <img src="<?= $menu_item["menu_icon"]; ?>" class="footer_menu_item_logo">
                                            <?php endif; ?>

                                            <?= $menu_item["menu_link"]["title"]; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-md-3">
        <div class="hstack align-items-start h-100 gap-4">
            <div class="vr"></div>

            <div class="vstack gap-3">
                <?php if ($footer_contact_title) : ?>
                    <div class="fs-5 fw-bold">
                        <?= $footer_contact_title; ?>
                    </div>
                <?php endif; ?>

                <?php if ($footer_contact_information_row && is_array($footer_contact_information_row) && !empty($footer_contact_information_row)) : ?>
                    <div class="vstack align-items-start gap-3">
                        <?php foreach ($footer_contact_information_row as $info_row) : ?>
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
                            <div class="hstack justify-content-between align-items-start">
                                <?php if ($label) : ?>
                                    <div class="fs-6 fw-bold">
                                        <?= $label; ?>
                                    </div>
                                <?php endif; ?>

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
    </div>

    <div class="col-md-12">
        <div class="text-center opacity-75 pt-5">
            <span>
                <?= $footer_copyright_text; ?>
            </span>

            <span>© <?= date("Y"); ?></span>
        </div>
    </div>
</div>