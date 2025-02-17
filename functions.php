<?php

// Auto load all of our php classes
spl_autoload_register(function ($class_name) {
    $file = get_template_directory() . "/inc/" . $class_name . ".inc.php";

    if (file_exists($file)) {
        require_once $file;
    }
});

// Hide "posts" and "comments" from admin panel
function hide_posts_and_comments()
{
    remove_menu_page("edit.php");

    remove_menu_page("edit-comments.php");
}
add_action("admin_menu", "hide_posts_and_comments", 10);

// Slices a sentence to the limit provided
// Returns the same string if it"s length is less that the limit
// Adds a afterfix ... to the string if not disabled
function truncate_sentence($sentence, $limit = 10, $afterfix = true)
{
    if (mb_strlen($sentence, "UTF-8") <= $limit) {
        return $sentence;
    }

    $result = mb_substr($sentence, 0, $limit, "UTF-8");
    return $result . ($afterfix ? "..." : "");
}

// Looks for page by it"s template name
function get_page_by_template($template_name)
{
    $args = [
        "post_type"      => "page",
        "posts_per_page" => 1,
        "meta_query"     => [
            [
                "key"   => "_wp_page_template",
                "value" => $template_name
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
function populate_cf7_property_type($tag)
{
    if ($tag["name"] !== "property_type") {
        return $tag;
    }

    $labels = ["סוג הפרויקט"];
    $values = [""];
    $property_type_selector = get_field("property_type_selector", "options");

    if ($property_type_selector && is_array($property_type_selector)) {
        foreach ($property_type_selector as $e) {
            if (isset($e["type"]) && !empty($e["type"])) {
                $values[] = $e["type"];
                $labels[] = $e["type"];
            }
        }
    }

    $tag["values"] = $values;
    $tag["labels"] = $labels;

    return $tag;
}

add_filter("wpcf7_form_tag", "populate_cf7_property_type", 10, 2);

function populate_cf7_subject($tag)
{
    if ($tag["name"] !== "subject") {
        return $tag;
    }

    $labels = ["נושא הפנייה"];
    $values = [""];
    $subject_selector = get_field("subject_selector", "options");

    if ($subject_selector && is_array($subject_selector)) {
        foreach ($subject_selector as $e) {
            if (isset($e["subject"]) && !empty($e["subject"])) {
                $values[] = $e["subject"];
                $labels[] = $e["subject"];
            }
        }
    }

    $tag["values"] = $values;
    $tag["labels"] = $labels;

    return $tag;
}

add_filter("wpcf7_form_tag", "populate_cf7_subject", 10, 2);


new SQLinkSCF();
new SQLinkEnqueue();
new AjaxHandler();
