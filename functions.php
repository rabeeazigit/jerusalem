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

add_action('admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=project',
        'ייבוא פרויקטים באמצעות CSV',
        'ייבוא CSV (AJAX)',
        'edit_others_posts',
        'import_projects_ajax',
        'render_ajax_import_page'
    );
});

function render_ajax_import_page()
{
?>
    <div class="wrap">
        <h1>ייבוא פרויקטים באמצעות CSV (AJAX)</h1>
        <form id="project-csv-upload-form" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button class="button button-primary" type="submit">העלאה וייבוא</button>
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
                    beforeSend: function() {
                        $('#csv-import-response').html('<p>ייבוא... אנא המתן.</p>');
                    },
                    success: function(response) {
                        $('#csv-import-response').html(response.data.message);
                    },
                    error: function(xhr) {
                        let msg = '<div class="notice notice-error"><p>אירעה שגיאה בלתי צפויה.</p></div>';
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

function handle_project_csv_ajax_upload()
{
    if (!current_user_can('edit_others_posts')) {
        wp_send_json_error(['message' => 'אין לך הרשאות לבצע פעולה זו.']);
    }

    if (empty($_FILES['csv_file']['tmp_name'])) {
        wp_send_json_error(['message' => 'לא הועלה קובץ.']);
    }

    $file_path = $_FILES['csv_file']['tmp_name'];
    $file_type = mime_content_type($file_path);

    if ($file_type !== 'text/csv' && $file_type !== 'application/vnd.ms-excel') {
        wp_send_json_error(['message' => 'פורמט קובץ לא תקין. יש להעלות קובץ CSV.']);
    }

    try {
        $message = import_projects_from_csv($file_path);
        wp_send_json_success(['message' => $message]);
    } catch (Exception $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}


function import_projects_from_csv($file_path)
{
    $errors = [];
    $imported = 0;

    try {
        if (!file_exists($file_path)) {
            throw new Exception('קובץ לא נמצא.');
        }

        if (($handle = fopen($file_path, 'r')) !== false) {
            $headers = fgetcsv($handle);
            $headers = array_map(function ($h) {
                $h = trim($h);
                $h = preg_replace('/\s+/', '_', $h);
                $h = preg_replace('/[^a-zA-Z0-9_]/', '', $h);
                return strtolower($h);
            }, $headers);

            $index = 0;
            while (($row = fgetcsv($handle)) !== false) {
                try {
                    $index++;
                    if (empty(array_filter($row))) continue;

                    $row = array_map(function ($value) {
                        return mb_convert_encoding(trim($value), 'UTF-8', 'auto');
                    }, $row);

                    $data = array_combine($headers, $row);

                    $title = $data['post_title'] ?? '';
                    if (!$title || trim($title) === '') {
                        throw new Exception("חסר כותרת בשורה " . "$index. " . "נתוני שורה: " . implode(", ", $row));
                    }

                    $existing_post = get_page_by_title($title, OBJECT, 'project');
                    if ($existing_post) {
                        $post_id = $existing_post->ID;
                    } else {
                        $post_id = wp_insert_post([
                            'post_title' => $title,
                            'post_type' => 'project',
                            'post_status' => 'publish',
                        ]);
                    }

                    if (!$post_id || is_wp_error($post_id)) {
                        throw new Exception("נכשל ניסיון ההוספה/עדכון של הפוסט: $title. נתוני שורה: " . implode(", ", $row));
                    }

                    update_field('project_address', $data['address'] ?? '', $post_id);
                    update_field('tabaa_number', $data['tabaa_number'] ?? '', $post_id);
                    update_field('project_entrepreneur', $data['entrepreneur'] ?? '', $post_id);
                    update_field('project_lowyer', $data['lawyer_name'] ?? '', $post_id);
                    update_field('area_description', $data['area_description'] ?? '', $post_id);
                    update_field('technon_link', $data['technon_link'] ?? '', $post_id);

                    $imported++;
                } catch (Throwable $rowError) {
                    $errors[] = $errors[] = "השורה מספר $index נכשלה: " . $rowError->getMessage() . " | נתוני שורה: " . implode(", ", $row);
                }
            }
            fclose($handle);
        }

        $message = "<div class=\"notice notice-success\"><p>✅ ייבוא $imported פרויקט(ים) הושלם בהצלחה!</p></div>";

        if (count($errors)) {
            $message .= '<div class="notice notice-warning"><p>חלק מהשורות נכשלו בייבוא:</p><ul><li>' . implode('</li><li>', array_map('esc_html', $errors)) . '</li></ul></div>';
        }

        return $message;
    } catch (Throwable $e) {
        return '<div class="notice notice-error"><p><strong>❌ שגיאה:</strong> ' . esc_html($e->getMessage()) . '</p></div>';
    }
}

new SQLinkSCF();
new SQLinkEnqueue();
new AjaxHandler();
