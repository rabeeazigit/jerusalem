<?php
$article_list_options = $args["article_list_options"] ;
$GetPillsCategories =  $article_list_options['GetPillsCategories'] ?? null;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="vstack">
                <div class="fs-5 fw-bold">
                    <?= $GetPillsCategories;?>
                </div>
            </div>
        </div>
    </div>
</div>