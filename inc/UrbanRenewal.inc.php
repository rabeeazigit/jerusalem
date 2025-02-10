<?php

class UrbanRenewal
{
    public $hero_title;
    public $hero_subtitle;

    public $faq_title;
    public $faq_side_image;
    public $faq_items;
    public $faq_background_image;

    public $external_links_title;
    public $external_links_subtitle;
    public $external_links_items;

    public function __construct()
    {
        $this->hero_title = get_field("hero_title") ?? null;
        $this->hero_subtitle = get_field("hero_subtitle") ?? null;

        $this->faq_title = get_field("faq_title") ?? null;
        $this->faq_side_image = get_field("faq_side_image") ?? null;
        $this->faq_items = get_field("faq_items") ?? null;
        $this->faq_background_image = get_field("faq_background_image") ?? null;

        $this->external_links_title = get_field("external_links_title") ?? null;
        $this->external_links_subtitle = get_field("external_links_subtitle") ?? null;
        $this->external_links_items = get_field("external_links_items") ?? null;
    }
}
