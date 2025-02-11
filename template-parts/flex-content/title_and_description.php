<?php
$title = $args["title"] ?? null;
$description = $args["description"] ?? null;
?>

<?php if ($title) : ?>
    <div class="fs-5 fw-bold mb-3">
        <?= $title; ?>
    </div>
<?php endif; ?>

<?php if ($description) : ?>
    <div class="fs-6 mb-4">
        <?= $description; ?>
    </div>
<?php endif; ?>