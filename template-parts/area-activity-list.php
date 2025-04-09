<?php

 $article_list_options = $args["article_list_options"] ;
// $article_list_title = $article_list_options["article_list_title"] ?? null;
// $article_list_items = $article_list_options["article_list_items"] ?? null;
// $article_list_link = $article_list_options["article_list_link"] ?? null;
 $article_list_side_image = $article_list_options["article_list_side_image"] ?? null;
$GetPillsCategories =  $article_list_options['GetPillsCategories'] ?? null;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-sm-12 ">
            <div class="vstack">
                
                    <div class="fs-5 fw-bold"><?php echo $GetPillsCategories;?></div>
               
            </div>
        </div>

        <?php if ($article_list_options && !wp_is_mobile()) : ?>
            <div class="col-6">
                <div class="d-flex w-100 h-100 align-items-center justify-content-end">
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
        </div>
    </div>
    </div>