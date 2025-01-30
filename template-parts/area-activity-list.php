<?php
$args
 //$article_list_options = $args["article_list_options"] ?? null;
// $article_list_title = $article_list_options["article_list_title"] ?? null;
// $article_list_items = $article_list_options["article_list_items"] ?? null;
// $article_list_link = $article_list_options["article_list_link"] ?? null;
// $article_list_side_image = $article_list_options["article_list_side_image"] ?? null;

?>

<?php if ($article_list_items && is_array($article_list_items) && !empty($article_list_items)) : ?>
    <div class="row">
        <?php if ($article_list_title) : ?>
            <div class="col-md-12">
                <div class="fs-1 fw-bold mb-3">
                    <?= $article_list_title; ?>
                </div>

                <hr>
            </div>
        <?php endif; ?>

        <div class="col-md-7">
            <div class="vstack">
                <?php foreach ($article_list_items as $e) : ?>
                  <?php //accordion?>
                    <div class="fs-5 fw-bold">WISAM</div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($article_list_side_image) : ?>
            <div class="col-md-5">
                <div class="d-flex w-100 h-100 align-items-center justify-content-start">
                    <img src="<?= $article_list_side_image; ?>" class="article_list_side_image">
                    <img src="<?= get_template_directory_uri() . "/assets/images/cube.png"; ?>" class="article_list_side_cube">
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>