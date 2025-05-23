<?php
$navbar = new Navbar();
$dark_theme = isset($args["dark_theme"]) && $args["dark_theme"] === true;
?>

<div class="d-xl-block d-none sticky-top" id="main-sticky-navbar" style="z-index: 99999;">
    <div id="main-sticky-navbar-sticky-section" class="container-fluid <?= $dark_theme ? "text-light navbar_light_mode linear_bg_page" : ""; ?> px-5">
        <div class="hstack justify-content-between align-items-center py-1 mb-3" id="top-navbar">
            <?php if ($navbar->social_media_links && is_array($navbar->social_media_links) && count($navbar->social_media_links) > 0) : ?>
                <div class="hstack gap-2 align-items-center">
                    <?php foreach ($navbar->social_media_links as $e) : ?>
                        <a href="<?= $e["link"]["url"] ?? "#"; ?>" target="<?= $e["link"]["target"] ?? ""; ?>" title="<?= $e["link"]["title"] ?? ""; ?>" class="text-reset text-decoration-none">
                            <?php if ($dark_theme) : ?>
                                <?php if ($e["icon_dark"]) : ?>
                                    <img src="<?= $e["icon_dark"]; ?>" alt="<?= $e["link"]["title"] ?? ""; ?>" class="navbar_social_icon">
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if ($e["icon"]) : ?>
                                    <img src="<?= $e["icon"]; ?>" alt="<?= $e["link"]["title"] ?? ""; ?>" class="navbar_social_icon">
                                <?php endif; ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="hstack gap-4">
                <?php if ($navbar->about_management_label && $navbar->about_management_links && is_array($navbar->about_management_links) && count($navbar->about_management_links) > 0) : ?>
                    <div class="dropdown">
                        <button
                            class="dropdown-toggle management_dropdown_toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                        >
                            <?= $navbar->about_management_label; ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end about_managment_menu p-3">
                            <div class="row align-items-center">
                                <?php if ($navbar->about_management_image) : ?>
                                    <div class="col-xl-6">
                                        <img src="<?= $navbar->about_management_image; ?>" class="about_management_image">
                                    </div>
                                <?php endif; ?>

                                <div class="col">
                                    <?php foreach ($navbar->about_management_links as $e) : ?>
                                        <?php if (isset($e["link"])) : ?>
                                            <li class="mega_menu_dropdown_item">
                                                <a class="dropdown-item" href="<?= $e["link"]["url"]; ?>" target="<?= $e["link"]["target"]; ?>">
                                                    <?= $e["link"]["title"]; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($navbar->events_courses_link && $navbar->events_courses_label) : ?>
                    <a href="<?= $navbar->events_courses_link; ?>" class="text-reset text-decoration-none">
                        <?= $navbar->events_courses_label; ?>
                    </a>
                <?php endif; ?>

                <?php if ($navbar->news_update_link && $navbar->news_update_label) : ?>
                    <a href="<?= $navbar->news_update_link; ?>" class="text-reset text-decoration-none">
                        <?= $navbar->news_update_label; ?>
                    </a>
                <?php endif; ?>

                <?php if ($navbar->owner_login_link && $navbar->owner_login_label) : ?>
                    <a href="<?= $navbar->owner_login_link; ?>" target="_blank" class="hstack gap-2 text-reset text-decoration-none">
                        <?php if ($navbar->owner_login_logo) : ?>
                            <img src="<?= $navbar->owner_login_logo; ?>" class="navbar_owner_logo">
                        <?php endif; ?>

                        <span><?= $navbar->owner_login_label; ?></span>
                    </a>
                <?php endif; ?>

                <div class="vr"></div>

                <div>
                    <?php if (!$dark_theme) : ?>
                        <img src="<?= get_template_directory_uri() . "/assets/images/contrast.png"; ?>" class="navbar_contrast_icon">
                    <?php else : ?>
                        <img src="<?= get_template_directory_uri() . "/assets/images/contrast_light.png"; ?>" class="navbar_contrast_icon">
                    <?php endif; ?>
                </div>


                <?php if ($navbar->accessibility_link && $navbar->accessibility_label) : ?>
                    <a href="<?= $navbar->accessibility_link["url"]; ?>" target="<?= $navbar->accessibility_link["target"]; ?>" class="text-reset text-decoration-none">
                        <?= $navbar->accessibility_label; ?>
                    </a>
                <?php endif; ?>

                <?php if (false) : ?>
                    <form action="#" method="get">
                        <select name="language" id="language" class="top_nav_select <?= $dark_theme ? "dark_top_nav" : "form-select"; ?>">
                            <option value="he">עברית</option>
                            <option value="en">English</option>
                        </select>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="hstack align-items-center justify-content-between main_menu_wrapper mt-4 position-relative" id="main-menu">
            <div class="h-100 ">
                <a href="<?= home_url(); ?>" class="h-100 hstack gap-2 align-items-center text-reset text-decoration-none">
                    <?php if ($navbar->brand_logo) : ?>
                        <?php 
                        $brand_text = get_template_directory_uri() . "/assets/images/ui/" . ($dark_theme ? "white_brand_text.svg" : "blue_brand_text.svg");
                        ?>

                        <div class="hstack gap-2 align-items-center">
                            <img src="<?= $navbar->brand_logo; ?>" class="navbar_brand_logo">
                            <img class="mobile_brand_text" id="desktop_brand_text" src="<?= $brand_text; ?>">
                        </div>
                    <?php endif; ?>
                </a>
            </div>

            <div class="h-100 ">
                <div class="hstack h-100 align-items-center main_menu gap-4 rounded-pill shadow px-4 main_menu_nav">
                    <?php if ($navbar->residents_menu_label) : ?>
                        <?php get_template_part("template-parts/mega-menu", null, [
                            "label" => $navbar->residents_menu_label,
                            "menu_cards" => $navbar->residents_menu_cards,
                            "menu_links" => $navbar->residents_menu_links
                        ]); ?>
                    <?php endif; ?>

                    <?php if ($navbar->entrepreneurs_menu_label) : ?>
                        <?php get_template_part("template-parts/mega-menu", null, [
                            "label" => $navbar->entrepreneurs_menu_label,
                            "menu_cards" => $navbar->entrepreneurs_menu_cards,
                            "menu_links" => $navbar->entrepreneurs_menu_links
                        ]); ?>
                    <?php endif; ?>

                    <?php if ($navbar->renewing_neighborhoods_link && $navbar->renewing_neighborhoods_label) : ?>
                        <a href="<?= $navbar->renewing_neighborhoods_link; ?>" class="fs-5 main_nav_item text-reset text-decoration-none">
                            <?= $navbar->renewing_neighborhoods_label; ?>
                        </a>
                    <?php endif; ?>

                    <div class="vr"></div>

                    <div class="hstack gap-1 searchbar_searchbox">
                        <img src="<?= get_template_directory_uri() . "/assets/images/search-glass.png"; ?>" class="navbar_searchglass">
                        <input class="site-searchbox" type="text" placeholder="<?= $navbar->searchbar_placeholder ?? ""; ?>">
                    </div>
                </div>
            </div>

            <div class="h-100">
                <div class="d-flex align-items-center justify-content-end">
                    <?php if ($navbar->contact_us_label) : ?>
                        <a href="<?= $navbar->contact_us_link; ?>" class="sq-secondary-button text-decoration-none shadow contact_us_btn" style="<?= $dark_theme ? "background-color: #235d8d" : ""; ?>">
                            <?= $navbar->contact_us_label; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-xl-none d-block">
    <div class="container-fluid px-0">
        <div class="vstack gap-3 top-nav-bar">
            <div class="hstack px-3 justify-content-between align-items-center py-2 top_navbar_wrapper_mobile">
                <?php if ($navbar->owner_login_link && $navbar->owner_login_label) : ?>
                    <a href="<?= $navbar->owner_login_link; ?>" target="_blank" class="fs-6 hstack gap-2 text-reset text-decoration-none text-mb-white">
                        <?php if ($navbar->owner_login_logo) : ?>
                            <img src="<?= $navbar->owner_login_logo; ?>" class="navbar_owner_logo">
                        <?php endif; ?>

                        <span><?= $navbar->owner_login_label; ?></span>
                    </a>
                <?php endif; ?>

                <div class="vr"></div>

                <div>
                    <img src="<?= get_template_directory_uri() . "/assets/images/contrast.png"; ?>" class="navbar_contrast_icon">
                </div>

                <?php if ($navbar->accessibility_link && $navbar->accessibility_label) : ?>
                    <a href="<?= $navbar->accessibility_link["url"]; ?>" target="<?= $navbar->accessibility_link["target"]; ?>" class="text-mb-white fs-5 text-reset text-decoration-none">
                        <?= $navbar->accessibility_label; ?>
                    </a>
                <?php endif; ?>

                <form action="#" method="get">
                    <select name="language" id="language" class="top_nav_select <?= $dark_theme ? "dark_top_nav" : "form-select"; ?>">
                        <option value="he">עברית</option>
                        <option value="en">English</option>
                    </select>
                </form>
            </div>

            <div class="hstack px-3 justify-content-between align-items-center">
                <div class="hstack gap-2">
                    <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#mobile-hamburger">
                        <img src="<?= get_template_directory_uri() . "/assets/images/" . ($dark_theme ? "hamburger-icon-light.svg" : "hamburger_icon.png"); ?>" alt="Open Nav Menu" class="img-fluid">
                    </button>

                    <a href="<?= home_url(); ?>" class="hstack gap-2 align-items-center text-reset text-decoration-none">
                        <?php if ($navbar->brand_logo) : ?>
                            <?php 
                            $brand_text = get_template_directory_uri() . "/assets/images/ui/" . ($dark_theme ? "white_brand_text.svg" : "blue_brand_text.svg");
                            ?>

                            <div class="hstack gap-2 align-items-center">
                                <img src="<?= $navbar->brand_logo; ?>" class="navbar_brand_logo">
                                <img class="mobile_brand_text" src="<?= $brand_text; ?>">
                            </div>
                        <?php endif; ?>
                    </a>
                </div>

                <?php if ($navbar->contact_us_label_mobile) : ?>
                    <a href="<?= $navbar->contact_us_link; ?>" class="fs-6 sq-secondary-button text-decoration-none shadow contact_us_btn">
                        <?= $navbar->contact_us_label_mobile; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-top" id="mobile-hamburger">
    <div class="offcanvas-header p-0">
        <div class="vstack gap-3 px-3">
            <div class="hstack justify-content-between align-items-center py-2 top_navbar_wrapper_mobile">
                <?php if ($navbar->owner_login_link && $navbar->owner_login_label) : ?>
                    <a href="<?= $navbar->owner_login_link; ?>" target="_blank" class="fs-5 hstack gap-2 text-reset text-decoration-none">
                        <?php if ($navbar->owner_login_logo) : ?>
                            <img src="<?= $navbar->owner_login_logo; ?>" class="navbar_owner_logo">
                        <?php endif; ?>

                        <span><?= $navbar->owner_login_label; ?></span>
                    </a>
                <?php endif; ?>

                <div class="vr"></div>

                <div>
                    <img src="<?= get_template_directory_uri() . "/assets/images/contrast.png"; ?>" class="navbar_contrast_icon">
                </div>

                <?php if ($navbar->accessibility_link && $navbar->accessibility_label) : ?>
                    <a href="<?= $navbar->accessibility_link["url"]; ?>" target="<?= $navbar->accessibility_link["target"]; ?>" class="fs-5 text-reset text-decoration-none">
                        <?= $navbar->accessibility_label; ?>
                    </a>
                <?php endif; ?>

                <form action="#" method="get">
                    <select name="language" id="language" class="form-select top_nav_select">
                        <option value="he">עברית</option>
                        <option value="en">English</option>
                    </select>
                </form>
            </div>

            <div class="hstack px-3 justify-content-between align-items-center">
                <button class="btn-close mx-0" data-bs-dismiss="offcanvas">
                </button>

                <a href="<?= home_url(); ?>" class="hstack gap-2 align-items-center text-reset text-decoration-none">
                    <?php if ($navbar->brand_logo) : ?>
                        <?php 
                        $brand_text = get_template_directory_uri() . "/assets/images/ui/blue_brand_text.svg";
                        ?>

                        <div class="hstack gap-2 align-items-center">
                            <img src="<?= $navbar->brand_logo; ?>" class="navbar_brand_logo">
                            <img class="mobile_brand_text" src="<?= $brand_text; ?>">
                        </div>
                    <?php endif; ?>
                </a>

                <?php if ($navbar->contact_us_label_mobile) : ?>
                    <a href="<?= $navbar->contact_us_link; ?>" class="fs-6 sq-secondary-button text-decoration-none shadow contact_us_btn">
                        <?= $navbar->contact_us_label_mobile; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="offcanvas-body">
        <div class="vstack mx-3">
            <div class="input-group px-2 border shadow rounded-pill">
                <span class="input-group-text mobile_searchbox">
                    <img src="<?= get_template_directory_uri() . "/assets/images/search-glass.png"; ?>" class="navbar_searchglass">
                </span>
                <input type="text" class="site-searchbox mobile_searchbox_input py-3" placeholder="<?= $navbar->searchbar_placeholder ?? ""; ?>">
            </div>
        </div>

        <?php
        $mobile_menus = $navbar->get_mobile_menus();
        $mobile_menu_length = count($mobile_menus);
        ?>

        <?php if ($mobile_menus && is_array($mobile_menus) && !empty($mobile_menus)) : ?>
            <div class="vstack px-3 my-3 gap-2">
                <?php foreach ($mobile_menus as $i => $e) : ?>
                    <?php if (count($e["links"]) > 1) : ?>
                        <div class="hstack align-items-center justify-content-between mobile_menu_head collapsed" data-bs-toggle="collapse" data-bs-target="#mobile_menu_item_<?= $i; ?>">
                            <div class="fs-5 fw-semibold">
                                <?= $e["label"]; ?>
                            </div>

                            <?php if (count($e["links"]) > 1) : ?>
                                <img src="<?= get_template_directory_uri() . "/assets/images/dropdown-arrow.png"; ?>">
                            <?php endif; ?>
                        </div>

                        <div class="collapse" id="mobile_menu_item_<?= $i; ?>">
                            <?php if ($e["links"] && is_array($e["links"])) : ?>
                                <div class="vstack gap-3 px-5">
                                    <?php foreach ($e["links"] as $link) : ?>
                                        <a class="text-reset fs-6 text-decoration-none" href="<?= $link["url"]; ?>">
                                            <?= $link["title"]; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <a class="text-reset fs-5 fw-semibold text-decoration-none" href="<?= $e["links"][0]["url"]; ?>">
                            <?= $e["links"][0]["title"]; ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($mobile_menu_length !== $i + 1) : ?>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // a script to override the default yoast home and seperator breadcrumbs icons
    $(function() {
        $(".sq_breadcrumbs *").each(function() {
            if ($(this).text().trim() === "[home]") {
                $(this).empty();

                $(this).html(`
                        <a href="<?= home_url(); ?>">
                            <img src="<?= get_template_directory_uri(); ?>/assets/images/<?= $dark_theme ? "home-light.svg" : "home.png" ?>" />
                        </a>
                    `);

                $(this).addClass("home_breadcrumb");
            }

            if ($(this).text().trim() === "[seperator]") {
                $(this).empty();
                $(this).addClass("seperator_breadcrumb");
            }
        });
    });
</script>

<?php if ($dark_theme) : ?>
    <script>
        $(() => {
            $(".seperator").addClass("light");
        })
    </script>
<?php endif; ?>