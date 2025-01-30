<?php
$article = $args["article"] ?? null;
$article_title = get_the_title($article) ?? null;
$article_date = get_field("article_date", $article) ?? null;
$article_description = get_field("article_description", $article) ?? null;
$article_date = get_field("article_date", $article) ?? null;
$article_link = get_permalink($article) ?? "#";

$month_section = explode(" | ", $article_date)[1] ?? "";
$day_section = explode("/", explode(" | ", $article_date)[0])[0];
$year_section = explode("/", explode(" | ", $article_date)[0])[2];
?>

<?php if ($article) : ?>
    <div class="hstack py-5 gap-4 article_list_tile">
        <div class="vstack">
            <div class="fw-semibold fs-4">
                <?= $day_section; ?>
            </div>

            <div class="opacity-75">
                <?= $month_section; ?>
            </div>

            <div class="opacity-75">
                <?= $year_section; ?>
            </div>
        </div>

        <a href="<?= $article_link; ?>" class="vstack text-reset text-decoration-none">
            <?php if ($article_title) : ?>
                <div class=" hstack justify-content-between align-items-center">
                    <div class="article_title fs-5 fw-semibold mb-2">
                        <?= $article_title; ?>
                    </div>

                    <img src="<?= get_template_directory_uri() . "/assets/images/yellow-arrow-left.png"; ?>" class="article_title_icon">
                </div>
            <?php endif; ?>

            <?php if ($article_description) : ?>
                <?php if (wp_is_mobile()) : ?>
                    <div class="fs-5">
                        <?= truncate_sentence($article_description, 80); ?>
                    </div>
                <?php else : ?>
                    <div class="fs-5">
                        <?= $article_description; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </a>
    </div>
<?php endif; ?>