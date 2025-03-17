<?php
$FilesDownload = $args ;
?>

<?php if ($FilesDownload && is_array($FilesDownload) && !empty($FilesDownload)) : ?>
    <p>מסמכים להורדה</p>

    <div class="container-fluid fs-6 text-center position-relative overflow-hidden">
        <div class="row">
            <?php foreach($FilesDownload as $file):?>
                <?php $downloadURI = $file['area_file_to_upload']['url'] ?? null ; ?>
                <div class="col-lg-4 col-sm-12 filedownload ">
                        <h2>
                            <?= $file['area_file_to_upload_title'];?>
                        </h2>
                    
                        <div class="fileicon">
                            <img src="<?= get_template_directory_uri()?>/assets/images/areas/file_img.png"/>
                        </div>
                    
                        <?php if (isset($file['area_file_to_upload_title_second']) && $file['area_file_to_upload_title_second']) : ?>
                            <div class="span">
                                <?= $file['area_file_to_upload_title_second'];?>
                            </div>
                        <?php endif; ?>

                        <?php if ($downloadURI) : ?>
                            <div class="filedownload_icon">
                                <a href="<?= $downloadURI ;?>" target="_blank"><img src="<?php echo get_template_directory_uri()?>/assets/images/areas/download.png"/></a>
                            </div>
                        <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>  
    </div>
<?php endif; ?>