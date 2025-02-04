<?php
$FilesDownload = $args ;

?>

<p>מסמכים להורדה</p>


   
<div class="container-fluid fs-6 text-center position-relative overflow-hidden">
<div class="row">
   
<?php foreach($FilesDownload as $file):?>
    <?php $downloadURI = $file['area_file_to_upload']['url'] ; ?>
  
<div class="col-lg-4 col-sm-12 filedownload ">
    <h2 ><?php echo $file['area_file_to_upload_title'];?></h2>   
    
     
        <div class="fileicon">
        <img src="<?php echo get_template_directory_uri()?>/assets/images/areas/file_img.png"/>
        </div>
   
      
        <div class="span"><?php echo $file['area_file_to_upload_title_second'];?></div>
            <div class="filedownload_icon">
            <a href="<?php echo $downloadURI ;?>" target="_blank"><img src="<?php echo get_template_directory_uri()?>/assets/images/areas/download.png"/></a>
            </div>
</div>
  
    <?php endforeach; ?>
    </div>  
 
</div>