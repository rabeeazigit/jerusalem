<?php

// Template Name: Urban Renewal Process

get_header();
?>

<?php $controller = new UrbanRenewal(); ?>

<div class="container-fluid" style="background-color: #174A75;">
    <?php get_template_part("template-parts/navbar", null, ["dark_theme" => true]); ?>
</div>

<?php get_footer(); ?>