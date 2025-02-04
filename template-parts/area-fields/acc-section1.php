<?php

$area_title = $args['area_title'];
$area_content = $args['area_content'];
$area_image = $args['area_image'];
$sticky = $args['sticky'];
$area_more_btn = $args['area_more_btn'];
?>

<h1><?=$area_title ;?></h1>
    <div class="container">
    <div class="row">
    <div class="col-lg-8 col-sm-12">
    <div class="GroupContent"><?=$area_content;?></div>
    </div>
    <div class="col-lg-4 col-sm-12 position-relative"><img src="<?=$area_image;?> " loading="lazy" <?=$sticky;?>/>
    </div>
    </div>
  
    <?php if($area_more_btn){ ?>
        <a href="<?php echo $area_more_btn ;?>" class=" sq-tertiary-button text-decoration-none " style="background:transparent;" >לפרטים נוספים</a>

        <?php }?>
</div>