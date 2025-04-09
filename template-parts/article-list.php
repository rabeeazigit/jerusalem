<?php
$article_list_options = $args["article_list_options"] ?? null;
$article_list_title = $article_list_options["article_list_title"] ?? null;
$article_list_items = $article_list_options["article_list_items"] ?? null;
$article_list_link = $article_list_options["article_list_link"] ?? null;
$article_list_side_image = $article_list_options["article_list_side_image"] ?? null;
?>

<?php if ($article_list_items && is_array($article_list_items) && !empty($article_list_items)) : ?>
    <?php
    usort($article_list_items, function ($a, $b) {
        $date_a = get_field("article_date", $a) ?? null;
        $date_b = get_field("article_date", $b) ?? null;

        if ($date_a) {
            $date_part = explode(" | ", $date_a);
            $date_a = $date_part[0];
        }

        if ($date_b) {
            $date_part = explode(" | ", $date_b);
            $date_b = $date_part[0];
        }

        $date_a = DateTime::createFromFormat('d/m/Y', $date_a)->format('Y-m-d');
        $date_b = DateTime::createFromFormat('d/m/Y', $date_b)->format('Y-m-d');
        
        return strtotime($date_b) - strtotime($date_a);
    });
    ?>
    
    <div class="row">
        <?php if ($article_list_title) : ?>
            <div class="col-md-12">
                <div class="fs-1 fw-bold mb-3 rubik">
                    <?= $article_list_title; ?>
                </div>

                <hr>
            </div>
        <?php endif; ?>

        <div class="col-md-7">
            <div class="vstack">
                <?php foreach ($article_list_items as $e) : ?>
                    <?php get_template_part("template-parts/article-list-tile", null, [
                        "article" => $e
                    ]); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!wp_is_mobile() && $article_list_side_image) : ?>
            <div class="col-md-5">
                <div class="d-flex w-100 h-100 align-items-center justify-content-start" style="padding-right: 100px;">
                    <img src="<?= $article_list_side_image; ?>" class="article_list_side_image">

                    <?php if (false) : ?>
                        <img
                            src="<?= get_template_directory_uri() . "/assets/images/cube.png"; ?>"
                            class="article_list_side_cube"
                        />
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($article_list_link) : ?>
            <div class="col-md-12">
                <a href="<?= $article_list_link["url"]; ?>" target="<?= $article_list_link["target"]; ?>" class="text-decoration-none sq-primary-button">
                    <?= $article_list_link["title"]; ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>