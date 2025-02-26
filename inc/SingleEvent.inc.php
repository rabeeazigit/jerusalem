<?php

class SingleEvent
{
    private $post;

    public $hero_title;
    public $hero_desc;
    public $post_type;
    public $details_show_gallery;
    public $details_side_image;
    public $details_gallery;
    public $detailed_content;
    public $external_form_link;

    public function __construct()
    {
        $this->post = get_queried_object();

        $this->hero_title = $this->post->post_title;
        $this->hero_desc = get_field("event_card_short_description", $this->post);
        $this->post_type = get_post_type($this->post) == "forum" ? "forum" : get_field("event_type", $this->post);
        $this->details_show_gallery = !empty(get_field("details_show_gallery", $this->post)) ? true : false;
        $this->details_side_image = get_field("details_side_image", $this->post);
        $this->details_gallery = get_field("details_gallery", $this->post);
        $this->detailed_content = get_field("detailed_content", $this->post);
        $this->external_form_link = get_field("external_form_link", $this->post);

        wp_enqueue_style(
            "single_event_styles",
            get_template_directory_uri() . "/assets/css/single-event.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/single-event.css"),
            "all"
        );

        wp_enqueue_script(
            "single_event_script",
            get_template_directory_uri() . "/assets/js/single-event.js",
            ["jquery_cdn"],
            filemtime(get_template_directory() . "/assets/js/single-event.js"),
            "all"
        );
    }
}
