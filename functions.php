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

// Looks for page by it's template name
function get_page_by_template($template_name)
{
    $args = [
        'post_type'      => 'page',
        'posts_per_page' => 1,
        'meta_query'     => [
            [
                'key'   => '_wp_page_template',
                'value' => $template_name
            ]
        ]
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        return $query->posts[0];
    }

    return null;
}

// customzing stuff in contact form 7

new SQLinkSCF();
new SQLinkEnqueue();
new AjaxHandler();
