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
        'Import Projects from CSV',
        'Import CSV',
        'manage_options',
        'import_projects_csv',
        'render_csv_import_page'
    );
});

function render_csv_import_page()
{
    ?>
    <div class="wrap">
        <h1>Import Projects from CSV</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <?php submit_button('Upload & Import'); ?>
        </form>
    </div>
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && current_user_can('manage_options')) {
        if (!empty($_FILES['csv_file']['tmp_name'])) {
            $file = $_FILES['csv_file']['tmp_name'];
            import_projects_from_csv($file);
        }
    }
}

// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', true); // So error isn't shown to visitors


function import_projects_from_csv($file_path)
{
    if (!file_exists($file_path)) {
        echo '<div class="notice notice-error"><p>CSV file not found.</p></div>';
        return;
    }

    $csv = array_map('str_getcsv', file($file_path));
    $headers = array_map('trim', array_shift($csv));

    foreach ($csv as $row) {
        $data = array_combine($headers, $row);
        if (!$data) continue;
    
        $title = $data['שם הפרויקט'] ?? '';
        if (!$title) continue;
    
        $existing_post = get_page_by_title($title, OBJECT, 'project');
        $post_id = $existing_post ? $existing_post->ID : wp_insert_post([
            'post_title'  => $title,
            'post_type'   => 'project',
            'post_status' => 'publish',
        ]);
    
        if (!$post_id || is_wp_error($post_id)) {
            error_log("Failed to insert/update project: $title");
            continue;
        }
    
        // Now update fields (safely)
        if (function_exists('update_field')) {
            update_field('project_address', $data['address'], $post_id);
            update_field('tabaa_number', $data['tabaa_number'], $post_id);
            update_field('project_entrepreneur', $data['entrepreneur'], $post_id);
            update_field('project_lowyer', $data['lawyer_name'], $post_id);
            update_field('area_description', $data['area_description'], $post_id);
            update_field('technon_link', $data['technon_link'], $post_id);            
        }
    
        if (!empty($data['סטטוס התקדמות התהליך'])) {
            wp_set_object_terms($post_id, $data['סטטוס התקדמות התהליך'], 'project-status');
        }
    
        if (!empty($data['שכונה'])) {
            $neighborhood = get_page_by_title($data['שכונה'], OBJECT, 'neighborhood');
            if ($neighborhood) {
                update_field('project_neighborhood', $neighborhood->ID, $post_id);
            }
        }
    }
    

    echo '<div class="notice notice-success"><p>Projects imported successfully!</p></div>';
}
