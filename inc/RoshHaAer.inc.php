<?php

class RoshHaAer
{
    public $page_title;
    public $page_content;
    public $side_image;
    public $mobile_side_image;

    public function __construct()
    {
        $this->page_title = get_field("rosh_ha_er_title") ?? null;
        $this->page_content = get_field("rosh_ha_er_content") ?? null;
        $this->side_image = get_field("rosh_ha_er_image") ?? null;
        $this->mobile_side_image = get_field("rosh_ha_er_image_mobile") ?? null;

        wp_enqueue_style(
            "rosh_ha_aer_css",
            get_template_directory_uri() . "/assets/css/rosh-ha-aer.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/rosh-ha-aer.css")
        );
    }
}
