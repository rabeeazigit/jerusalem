<?php

class GenericTemplate
{
    public $page_title;
    public $page_content;
    public $side_image;
    public $flex_content;
    public $show_flex_content_bg;
    public $mobile_side_image;

    public function __construct()
    {
        $this->page_title = get_field("generic_template_title") ?? null;
        $this->page_content = get_field("generic_template_content") ?? null;
        $this->side_image = get_field("generic_template_image") ?? null;
        $this->mobile_side_image = get_field("generic_template_image_mobile") ?? null;
        $this->flex_content = get_field("generic_template_flex_content") ?? null;
        $this->show_flex_content_bg = get_field("generic_template_show_flex_content_bg") ?? false;

        wp_enqueue_style(
            "generic_template_css",
            get_template_directory_uri() . "/assets/css/generic-template.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/generic-template.css")
        );
    }
}
