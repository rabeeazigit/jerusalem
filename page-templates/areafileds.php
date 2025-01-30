<?php 
/**
 * Template Name: Area Fields
 * Description: About Page By Wisam.
 */
get_header();
$Areafields = new Areafields;
$AFcats = $Areafields->FetchAreaFiedlsCategories();
?>

<section class="hero-section">
<?php
echo $Areafields->MainHeader();
 echo $Areafields->HeroSeccssion();
 $rrr = $Areafields->LeftSideCats();
// echo $About->SexyNumber();
?>
</section>
<section id="categories">
<div class="container-fluid px-5 py-5 mt-5 article_list_wrapper">
    
    <?php  get_template_part("template-parts/area-activity-list", null , [
    'article_list_options'=>['article_list_side_image'=>$rrr]
]); ?>
</div>
</section>

<section id="howcanwehelp">
<?php get_template_part('template-parts/howcanwehelp');?>
</section>
<?php get_footer();?>