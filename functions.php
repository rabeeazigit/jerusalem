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


 add_action('admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=project',
        'Import Projects via CSV',
        'Import CSV (AJAX)',
        'edit_others_posts',
        'import_projects_ajax',
        'render_ajax_import_page'
    );
});

function render_ajax_import_page() {
    ?>
    <div class="wrap">
        <h1>Import Projects via CSV (AJAX)</h1>
        <form id="project-csv-upload-form" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button class="button button-primary" type="submit">Upload & Import</button>
        </form>
        <div id="csv-import-response" style="margin-top: 20px;"></div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#project-csv-upload-form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('action', 'import_project_csv_ajax');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#csv-import-response').html('<p>Importing... please wait.</p>');
                },
                success: function (response) {
                    $('#csv-import-response').html(response.data.message);
                },
                error: function (xhr) {
                    let msg = '<div class="notice notice-error"><p>Unexpected error occurred.</p></div>';
                    if (xhr.responseJSON?.data?.message) {
                        msg = '<div class="notice notice-error"><p>' + xhr.responseJSON.data.message + '</p></div>';
                    }
                    $('#csv-import-response').html(msg);
                }
            });
        });
    }); 
    </script>
    <?php
}

add_action('wp_ajax_import_project_csv_ajax', 'handle_project_csv_ajax_upload');

function handle_project_csv_ajax_upload() {
    if (!current_user_can('edit_others_posts')) {
        wp_send_json_error(['message' => 'Permission denied.']);
    }

    if (empty($_FILES['csv_file']['tmp_name'])) {
        wp_send_json_error(['message' => 'No file uploaded.']);
    }

    $file_path = $_FILES['csv_file']['tmp_name'];
    $message = import_projects_from_csv($file_path);

    wp_send_json_success(['message' => $message]);
}

function get_closest_term_id($value, $taxonomy) {
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ]);

    foreach ($terms as $term) {
        if (trim($value) === $term->name || stripos($term->name, $value) !== false || stripos($value, $term->name) !== false) {
            return $term->term_id;
        }
    }

    $new_term = wp_insert_term($value, $taxonomy, ['slug' => sanitize_title($value)]);
    if (is_wp_error($new_term)) {
        throw new Exception("Failed to create term in taxonomy '$taxonomy': $value");
    }
    return $new_term['term_id'];
}

function get_or_create_neighborhood($name) {
    $name = trim(preg_replace('/\s+/', ' ', $name));
    $existing = get_page_by_title($name, OBJECT, 'neighborhood');

    if ($existing) {
        return $existing->ID;
    }

    $new_id = wp_insert_post([
        'post_title' => $name,
        'post_type' => 'neighborhood',
        'post_status' => 'publish'
    ]);

    if (is_wp_error($new_id)) {
        throw new Exception("Failed to create neighborhood: $name");
    }

    return $new_id;
}

function import_projects_from_csv($file_path) {
    $errors = [];

    try {
        if (!file_exists($file_path)) {
            throw new Exception('CSV file not found.');
        }

        $csv = [];
        $raw_lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!$raw_lines || count($raw_lines) < 2) {
            throw new Exception('CSV is empty or malformed.');
        }

        $headers = array_map(function($h) {
            $h = trim($h);
            $h = preg_replace('/\s+/', '_', $h);
            $h = preg_replace('/[^a-zA-Z0-9_]/', '', $h);
            return strtolower($h);
        }, str_getcsv(array_shift($raw_lines)));

        foreach ($raw_lines as $index => $line) {
            try {
                $row = str_getcsv($line);

                if (count(array_filter($row)) === 0) continue;

                $row = array_pad($row, count($headers), '');
                $row = array_slice($row, 0, count($headers));
                $data = array_combine($headers, $row);

                $title = $data['post_title'] ?? '';
                if (!$title || trim($title) === '') {
                    throw new Exception("Missing title on row $index.");
                }

                $existing_post = get_page_by_title($title, OBJECT, 'project');
                $post_id = $existing_post ? $existing_post->ID : wp_insert_post([
                    'post_title'  => $title,
                    'post_type'   => 'project',
                    'post_status' => 'publish',
                ]);

                if (!$post_id || is_wp_error($post_id)) {
                    throw new Exception("Failed to insert/update post: $title");
                }

                update_field('project_address', $data['address'] ?? '', $post_id);
                update_field('tabaa_number', $data['tabaa_number'] ?? '', $post_id);
                update_field('project_entrepreneur', $data['entrepreneur'] ?? '', $post_id);
                update_field('project_lowyer', $data['lawyer_name'] ?? '', $post_id);
                update_field('area_description', $data['area_description'] ?? '', $post_id);
                update_field('technon_link', $data['technon_link'] ?? '', $post_id);

                if (!empty($data['status'])) {
                    $term_id = get_closest_term_id($data['status'], 'project-status');
                    wp_set_object_terms($post_id, (int)$term_id, 'project-status');
                }

                if (!empty($data['neighborhood'])) {
                    $neigh_id = get_or_create_neighborhood($data['neighborhood']);
                    update_field('project_neighborhood', $neigh_id, $post_id);
                }
            } catch (Throwable $rowError) {
                $errors[] = "Row $index: " . $rowError->getMessage();
            }
        }

        if (count($errors)) {
            return '<div class="notice notice-warning"><p>Imported with warnings:</p><ul><li>' . implode('</li><li>', array_map('esc_html', $errors)) . '</li></ul></div>';
        }

        return '<div class="notice notice-success"><p>✅ Projects imported successfully!</p></div>';

    } catch (Throwable $e) {
        return '<div class="notice notice-error"><p><strong>❌ Error:</strong> ' . esc_html($e->getMessage()) . '</p></div>';
    }
}