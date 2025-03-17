<?php if (isset($videos) && is_array($videos) && !empty($videos)) : ?>
    <div id="carouselExample_<?= $pid ;?>" class="carousel slide ">
        <div class="carousel-inner">
            <?php foreach($sec_videos_Args as $videos) : ?>
                <?php 
                $video_title = $videos['area_video_title'] ?? '';
                $video_raw = $videos['area_video_url'] ? explode('=', $videos['area_video_url']) : '';
                $video =  $video_raw[1];
                ?>
            
                <div class="carousel-item active">
                    <div class="videoTitle">
                        <h4>
                            <?= $video_title;?>
                        </h4>
                    </div>

                    <?php if ($video) : ?>
                        <iframe
                            width="100%"
                            height="400"
                            src="https://www.youtube.com/embed/<?= $video; ?>"         
                            title="<?= $video_title;?>" 
                            frameborder="0"
                            loading="lazy"
                            allow="accelerometer;  gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        >
                        </iframe>
                    <?php endif; ?>
                </div> 
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample_<?= $pid; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample_<?= $pid ;?>" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<?php endif; ?>