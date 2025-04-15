<?php
$image = $args["image"] ?? null;
?>

<?php if ($image && is_array($image)) : ?>
    <div class="d-flex flex-column align-items-start justify-content-center py-4 gap-1">
        <img class="img-fluid" src="<?= $image["url"]; ?>" alt="<?= $image["alt"]; ?>" title="<?= $image["title"]; ?>" />
        <?php if (isset($image["caption"]) && !empty($image["caption"])) : ?>
            <caption>
                <small>
                    <?= $image["caption"]; ?>
                </small>
            </caption>
        <?php endif; ?>

        <?php if (isset($image["description"]) && !empty($image["description"])) : ?>
            <div class="fs-6">
                <?= $image["description"]; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>