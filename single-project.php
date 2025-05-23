<?php
get_header();
$controller = new SingleProject;

?>

<?php get_template_part("template-parts/navbar"); ?>

<section class="hero-section">
    <?php if (function_exists("yoast_breadcrumb")) : ?>
        <div class="sq_breadcrumbs pt-5 px-md-5 px-3 fs-5">
            <?php yoast_breadcrumb(); ?>
        </div>
    <?php endif; ?>

    <?php
    echo $controller->HeroSeccssion();
    //echo $controller->HeroSeccssion2();
    ?>
</section>

<?php if (count($controller->fetured_projects) > 0) : ?>
    <section class="projects_sec py-5" style="background-color: #EBE8E3">
        <div class="text-center display-2 fw-semibold rubik mb-4">
            פרויקטים נוספים
        </div>

        <?php $controller->GetProjectsToDisplay(); ?>
    </section>
<?php endif; ?>

<section id="howcanwehelp">
    <?php get_template_part('template-parts/howcanwehelp'); ?>
</section>
<script>
    $('.fadeCarousle').slick({
        centerMode: true,
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        rtl: true,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><img src="<?= get_stylesheet_directory_uri() ?>/assets/images/carousel/right-arrow.png" alt="Previous"></button>',
        nextArrow: '<button type="button" class="slick-next"><img src="<?= get_template_directory_uri() ?>/assets/images/carousel/left-arrow.png" alt="Next"></button>',
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                centerMode: false
            }
        }]
    });
</script>
<?php
get_footer();
?>