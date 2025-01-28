<?php 
$hwch_image = get_field("hwch_image", "options");
$hwch_title = get_field("hwch_title", "options");
$hwch_text = get_field("hwch_text", "options");
$hcwh_link = get_field("hcwh_link", "options");
?>

<div class="container-fluid howcanwehelp" style="background:url('<?php echo get_template_directory_uri();?>/assets/images/about/bk1.png');">
  <div class="row align-items-center p-5">
    <div class="col align-items-center text-center">
      <img src="<?php echo $hwch_image ;?>" loading="lazy"/>
    </div>
    <div class="col align-items-center">
      <h1 class="hcwhy-h"><?php echo $hwch_title;?></h1>
      <div class="hcwhy-p"><?php echo $hwch_text ;?></div>
      <a  href="<?php echo $hcwh_link['url'] ;?>" class="text-decoration-none tertiary_button_trans"><?php echo $hcwh_link['title'] ?></a>
    </div>
   
  </div>
  
</div>