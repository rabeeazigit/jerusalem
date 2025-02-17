<?php

$target_page = get_page_by_template("page-templates/events-articles.php");

if ($target_page) {
    $url = get_permalink($target_page);
} else {
    $url = home_url();
}

wp_redirect($url);
