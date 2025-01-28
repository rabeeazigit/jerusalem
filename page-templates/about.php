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
echo $About->HeroSeccssion();
echo $About->SexyNumber();
?>
</section>

<section id="activities">
    <?php  $About->AreaOfActivities();?>
</section>



<section id="staff">
    <?php  echo $About->OurStaff();?>
</section>


<?php get_footer();?>
