<?php

// Auto load all of our php classes
spl_autoload_register(function ($class_name) {
    $file = get_template_directory() . '/inc/' . $class_name . '.inc.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Hide 'posts' and 'comments' from admin panel
function hide_posts_and_comments()
{
    remove_menu_page('edit.php');

    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'hide_posts_and_comments', 999);

// Slices a sentence to the limit provided
// Returns the same string if it's length is less that the limit
// Adds a afterfix ... to the string if not disabled
function truncate_sentence($sentence, $limit = 10, $afterfix = true)
{
    if (mb_strlen($sentence, 'UTF-8') <= $limit) {
        return $sentence;
    }

    $result = mb_substr($sentence, 0, $limit, 'UTF-8');
    return $result . ($afterfix ? "..." : "");
}


// Will be enabled later on
// new SQLinkSCF();
new SQLinkEnqueue();
