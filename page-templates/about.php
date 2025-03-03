<?php

/**
 * Template Name: About
 * Description: About Page By Wisam.
 */
get_header();
$About = new About;

?>
<section class="hero-section">
    <?php
    echo $About->MainHeader();
    ?>

    <?php if (function_exists("yoast_breadcrumb")) : ?>
        <div class="sq_breadcrumbs pt-5 px-md-5 px-3 fs-5">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>

    <?php
    echo $About->HeroSeccssion();
    echo $About->SexyNumber();
    ?>
</section>

<section id="activities">
    <?php $About->AreaOfActivities(); ?>
</section>



<section id="staff">
    <?php echo $About->OurStaff(); ?>
</section>

<section id="howcanwehelp">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>
<?php get_footer(); ?>