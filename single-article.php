<?php

$controller = new SingleArticle();

get_header();
?>

<div class="single-article-container">
    <?php get_template_part("template-parts/navbar"); ?>

    <header class="container-fluid px-md-5 px-3">
        <?php if (function_exists("yoast_breadcrumb")) : ?>
            <div class="sq_breadcrumbs pt-5 fs-5">
                <?php yoast_breadcrumb(); ?>
            </div>
        <?php endif; ?>
    </header>

    <main class="container single-article-main-container my-4">
        <?php if ($controller->page_title) : ?>
            <div class="text-center display-4 fw-bold mb-3">
                <?= $controller->page_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->article_description) : ?>
            <div class="text-center fs-5 mb-3">
                <?= $controller->article_description; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->article_date) : ?>
            <div class="text-center fs-6">
                <?= $controller->article_date; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->detailed_content && is_array($controller->detailed_content) && !empty($controller->detailed_content)) : ?>
            <div class="my-4">
                <?php foreach ($controller->detailed_content as $e) : ?>
                    <?php $controller->get_dynamic_template($e); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php if ($controller->related_articles && is_array($controller->related_articles) && !empty($controller->related_articles)) : ?>
    <div class="container-fluid my-4">
        <?php if ($controller->related_articles_title) : ?>
            <div class="display-5 text-center fw-bold mb-4">
                <?= $controller->related_articles_title; ?>
            </div>
        <?php endif; ?>

        <?php if ($controller->related_articles) : ?>
            <div class="row row-gap-3">
                <?php foreach ($controller->related_articles as $e) : ?>
                    <div class="col-md-4">
                        <?php
                        $title = $e->post_title ?? null;
                        $image = get_field("article_image", $e) ?? null;
                        $description = get_field("article_description", $e) ?? null;
                        $date = get_field("article_date", $e) ?? null;
                        ?>

                        <a href="<?= get_permalink($e); ?>" class="text-reset text-decoration-none hstack gap-5 align-items-start p-3 py-4 article_card_elm">
                            <div class="row">
                                <div class="col-2">
                                    <?php if ($date) : ?>
                                        <?php
                                        $month = explode(" | ", $date)[1] ?? "";
                                        $day = explode("/", explode(" | ", $date)[0])[0];
                                        $year = explode("/", explode(" | ", $date)[0])[2];
                                        ?>
                                        <div class="vstack">
                                            <div class="fw-semibold fs-4">
                                                <?= $day; ?>
                                            </div>

                                            <div class="opacity-75">
                                                <?= $month; ?>
                                            </div>

                                            <div class="opacity-75">
                                                <?= $year; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-9">
                                    <?php if ($title || $description) : ?>
                                        <div class="vstack gap-2">
                                            <?php if ($title) : ?>
                                                <div class="fs-4 fw-bold">
                                                    <?= $title; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($description) : ?>
                                                <div class="fs-6">
                                                    <?= $description; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-1">
                                    <img src="<?= get_template_directory_uri() . "/assets/images/yellow-arrow-left.png"; ?>" class="single-article-card-arrow">
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>