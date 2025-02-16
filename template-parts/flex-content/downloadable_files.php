<?php
$title = $args["title"] ?? null;
$files = $args["files"] ?? null;
?>

<?php if ($title) : ?>
    <div class="fs-5 fw-bold mb-3">
        <?= $title; ?>
    </div>
<?php endif; ?>

<?php if ($files && is_array($files) && !empty($files)) : ?>
    <div class="row row-gap-3 mb-4">
        <?php foreach ($files as $file) : ?>
            <?php
            $file_link = "";
            if (get_field("is_external_file", $file)) {
                $file_link = get_field("file_url", $file);
            } else {
                $file_link = get_field("file", $file);
            }
            ?>
            <div class="col-md-4">
                <a data-search="<?= (get_field("short_description", $file) ?? "") . "," . (get_field("display_name", $file)); ?>" download target="_blank" href="<?= $file_link; ?>" class="border rounded-3 text-decoration-none text-reset hstack gap-2 align-items-center downloadable_file_item rounded-4 p-3">
                    <img src="<?= get_template_directory_uri() . "/assets/images/doc.png"; ?>" style="width: 32px; height: 32px; align-self: flex-start">

                    <div class="vstack gap-2">
                        <div class="fs-5 fw-bold">
                            <?= get_field("display_name", $file); ?>
                        </div>

                        <div class="fs-6">
                            <?php
                            $word_limit = 80;

                            if (isset($args["word_limit"]) && is_numeric($args["word_limit"]) && intval($args["word_limit"]) > 0) {
                                $word_limit = intval($args["word_limit"]);
                            }
                            ?>
                            <?= truncate_sentence(get_field("short_description", $file) ?? "", $word_limit); ?>
                        </div>
                    </div>

                    <img src="<?= get_template_directory_uri() . "/assets/images/download.png"; ?>" style="width: 32px; height: 32px; align-self: flex-end">
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>