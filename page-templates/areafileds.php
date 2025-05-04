<?php
/**
 * Template Name: Area Fields
 * Description:  By Wisam Shomar.
 */
get_header();

$Areafields = new Areafields;
$AFcats = $Areafields->FetchAreaFiedlsCategories();
$GetPillsCategories = $Areafields->GetPillsCategories();

?>

<?php get_template_part("template-parts/navbar"); ?>

<section class="hero-section">
    <?php
    echo $Areafields->HeroSeccssion();
    $rightsideCats = $Areafields->LeftSideCats();
    ?>
</section>
<section id="categories" class="">
    <div class="container-fluid px-md-5 px-3 py-5  article_list_wrapper">

        <?php 
        get_template_part("template-parts/area-activity-list", null, [
            'article_list_options' => [
                'article_list_side_image' => $rightsideCats,
                'GetPillsCategories' => $GetPillsCategories
            ]
        ]); 
        ?>
    </div>

</section>

<section id="howcanwehelp">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>

<script>
    jQuery(function ($) {
        $(".to_be_hidden").each(function () {
            const $button = $(this).find("button");
            const $tab = $($button.attr('data-bs-target'));

            $button.hide();
            $tab.hide();

            $(".nav-item:not(.to_be_hidden) .activeFieldLink").first().trigger("click");
        });

    });
</script>

<?php get_footer(); ?>