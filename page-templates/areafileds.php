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

<section class="hero-section">
<?php
echo $Areafields->MainHeader();
echo $Areafields->HeroSeccssion();
$rightsideCats = $Areafields->LeftSideCats();
?>
</section>
<section id="categories">
<div class="container-fluid px-md-5 px-3 py-5  article_list_wrapper">
    
    <?php  get_template_part("template-parts/area-activity-list", null, [
    'article_list_options' => ['article_list_side_image' => $rightsideCats,
     'GetPillsCategories' => $GetPillsCategories
     ]
]); ?>


</div>

</section>

<section id="howcanwehelp">
<?php get_template_part('template-parts/howcanwehelp');?>
</section>

<?php get_footer();?>