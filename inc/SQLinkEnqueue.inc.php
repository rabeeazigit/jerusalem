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
            wp_enqueue_style("custom_bs_css", get_template_directory_uri() . "/assets/css/custom-bootstrap.css", filemtime(get_template_directory() . "/assets/css/custom-bootstrap.css"), ["main_css"], "all");
            $this->enqueue_styles();

            // Enqueue scripts
            wp_dequeue_script("jquery");
            wp_enqueue_script("jquery_cdn", "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js", [], "3.7.1");
            wp_enqueue_script("slick_js", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js", ["jquery_cdn"], "1.9.0");
            wp_enqueue_script("bs_js", "https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js", ["jquery_cdn"], "5.3.3");
            wp_enqueue_script("framer_motion", "https://cdn.jsdelivr.net/npm/motion@11.11.13/dist/motion.js", [], "11.11.13");
            wp_enqueue_script(
                'jquery_marquee',
                'https://cdnjs.cloudflare.com/ajax/libs/jQuery.Marquee/1.6.1/jquery.marquee.min.js',
                ['jquery_cdn'],
                '1.6.1'
            );

            wp_enqueue_script(
                "global_js",
                get_template_directory_uri() . "/assets/js/global.js",
                ["jquery_cdn", "slick_js", "bs_js"],
                filemtime(get_template_directory() . "/assets/js/global.js")
            );

            wp_localize_script(
                "global_js",
                "wpAjax",
                [
                    "ajaxUrl" => admin_url("admin-ajax.php"),
                    "ajaxNonce" => wp_create_nonce("sq_site_search")
                ]
            );
        });
    }

    //Wisam
    public function enqueue_styles()
    {

        $handle = 'wstyle';
        $src = get_template_directory_uri() . '/assets/css/wstyle.css';
        $deps = array(); // No dependencies
        $ver = '1.0.0'; // Version number
        $media = 'all'; // Media type

        // Enqueue the style
        wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }
}
