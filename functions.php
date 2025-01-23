<?php

// Auto load all of our php classes
spl_autoload_register(function ($class_name) {
    $file = get_template_directory() . '/inc/' . $class_name . '.inc.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

new SQLinkEnqueue();
