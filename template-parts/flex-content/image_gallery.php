<?php
$gallery = $args["gallery"] ?? null;
$subtitle = $args["subtitle"] ?? null;
?>

<?php if ($gallery && is_array($gallery) && !empty($gallery)) : ?>
    <div class="image_gallery_wrapper my-4">
        <div class="image_gallery_slider">
            <?php foreach ($gallery as $e) : ?>
                <div
                    class="image_gallery_image_item rounded-4"
                    style="
                        background: linear-gradient(to top, black , transparent 20%), url(<?= $e; ?>);
                        background-repeat: no-repeat;
                        background-size: cover;
                    ">
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($subtitle) : ?>
            <div class="mt-md-3 mt-1 fs-5">
                <?= $subtitle; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>