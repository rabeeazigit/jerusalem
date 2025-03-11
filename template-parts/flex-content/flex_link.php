<?php
$link_values = $args["link_values"] ?? null;
$link_position = $args["link_position"] ?? null;
?>

<?php if ($link_values && is_array($link_values) && isset($link_values["url"]) && !empty($link_values["url"])) : ?>
    <?php 
    $default_aligns = ["start", "center", "end"];
    $flex_align = "center";

    // Check wether the actual value provided is supported in flexbox
    // if yes then change the flex_align property
    if (in_array($link_position, $default_aligns)) {
        $flex_align = $link_position;
    }
    ?>
    
    <div class="py-4 d-flex align-items-center justify-content-<?= $flex_align; ?>">
        <a href="<?= $link_values["url"]; ?>" target="<?= $link_values["target"]; ?>" class="text-decoration-none sq-primary-button px-3">
            <?= $link_values["title"]; ?>
        </a>
    </div>
<?php endif; ?>