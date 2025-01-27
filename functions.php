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


new SQLinkEnqueue();
