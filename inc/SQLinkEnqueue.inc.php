<?php

class SQLinkEnqueue
{
    public function __construct()
    {
        add_action("wp_enqueue_scripts", function () {
            // Enqueue styles
            wp_enqueue_style("bs_css", "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.rtl.min.css", [], "5.3.3", "all");
            wp_enqueue_style("slick_css", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css", [], "1.9.0", "all");
            wp_enqueue_style("slick_theme_css", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css", [], "1.9.0", "all");
            wp_enqueue_style("main_css", get_template_directory_uri() . "/style.css", ["bs_css"], filemtime(get_template_directory() . "/style.css"), "all");

            // Enqueue scripts
            wp_dequeue_script("jquery");
            wp_enqueue_script("jquery_cdn", "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js", [], "3.7.1");
            wp_enqueue_script("slick_js", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js", ["jquery_cdn"], "1.9.0");
            wp_enqueue_script("bs_js", "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js", ["jquery_cdn"], "5.3.3");
        });
    }
}
