<?php get_header(); ?>

<div class="home_header_wrapper">
    <?php get_template_part("template-parts/navbar"); ?>

    <?php
    $main_title = get_field("main_title") ?? null;
    $sub_title = get_field("sub_title") ?? null;
    ?>

    <div class="vstack my-3 px-5">
        <?php if ($main_title) : ?>
            <div class="display-4 fw-semibold">
                <?= $main_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($sub_title) : ?>
            <div class="display-4 fw-bold home_sbutitle">
                <?= $sub_title; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php get_template_part("template-parts/carousel", null, [
        "carousel_items" => array_reverse(get_field("carousel_items") ?? [])
    ]); ?>

    <div>
        <!-- IMPLEMENT CAROUSEL NEWS SLIDE -->
    </div>
</div>

<?php get_footer(); ?>