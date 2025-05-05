<?php

class InformationTemplate {
    public $hero_background_image;
    public $hero_title;
    public $hero_description;
    public $hero_side_image;
    public $hero_side_image_mobile;

    public $urban_renewal_title;
    public $urban_renewal_link;

    public $rights_show_bg_image;
    public $resident_rights_title;
    public $resident_rights_link;
    public $stage_cards;

    public $faq_title;
    public $faq_side_image;
    public $faq_items;
    public $faq_background_image;

    public $event_slider_title;
    public $event_slider_description;
    public $event_slider_link;
    public $event_slider_items;

    public $downloadable_files_title;
    public $downloadable_files_subtitle;
    public $file_categories_to_show;

    public $external_links_title;
    public $external_links_subtitle;
    public $external_links_items;

    public $renewal_stages;
    public $urban_renewal_stage_page;
    
    public function __construct() {
        $this->hero_background_image = get_field("hero_background_image") ?? null;
        $this->hero_title = get_field("hero_title") ?? null;
        $this->hero_description = get_field("hero_description") ?? null;
        $this->hero_side_image = get_field("hero_side_image") ?? null;
        $this->hero_side_image_mobile = get_field("hero_side_image_mobile") ?? null;

        $this->urban_renewal_title = get_field("urban_renewal_title") ?? null;
        $this->urban_renewal_link = get_field("urban_renewal_link") ?? null;

        $this->rights_show_bg_image = get_field("rights_show_bg_image") ?? false;
        $this->resident_rights_title = get_field("resident_rights_title") ?? null;
        $this->resident_rights_link = get_field("resident_rights_link") ?? null;
        $this->stage_cards = get_field("stage_section_cards") ?? null;

        $this->faq_title = get_field("faq_title") ?? null;
        $this->faq_side_image = get_field("faq_side_image") ?? null;
        $this->faq_items = get_field("faq_items") ?? null;
        $this->faq_background_image = get_field("faq_background_image") ?? null;

        $this->event_slider_title = get_field("event_slider_title") ?? null;
        $this->event_slider_description = get_field("event_slider_description") ?? null;
        $this->event_slider_link = get_field("event_slider_link") ?? null;
        $this->event_slider_items = get_field("event_slider_items") ?? null;

        $this->downloadable_files_title = get_field("downloadable_files_title") ?? null;
        $this->downloadable_files_subtitle = get_field("downloadable_files_subtitle") ?? null;
        $this->file_categories_to_show = get_field("file_categories_to_show") ?? null;

        $this->external_links_title = get_field("external_links_title") ?? null;
        $this->external_links_subtitle = get_field("external_links_subtitle") ?? null;
        $this->external_links_items = get_field("external_links_items") ?? null;

        $this->renewal_stages = get_field("renewal_stages") ?? null;
        $this->urban_renewal_stage_page = get_field("urban_renewal_stage_page") ?? null;
        
        wp_enqueue_script(
            "information_template_js",
            get_template_directory_uri() . "/assets/js/information-template.js",
            [],
            filemtime(get_template_directory() . "/assets/js/information-template.js")
        );

        wp_enqueue_style(
            "information_template_css",
            get_template_directory_uri() . "/assets/css/information-template.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/information-template.css")
        );
    }

    public function get_urban_renewal_processes($category) {
        return get_posts([
            "post_type" => "urban-renewal-proces",
            "posts_per_page" => -1,
            "orderby" => "ID",
            "order" => "ASC",
            "tax_query" => [
                [
                    "taxonomy" => "urban-renewal-process-category",
                    "field"    => "term_id",
                    "terms"    => $category,
                ]
            ]
        ]);
    }

    public function get_files_by_category($category) {
        // If more than one category is sent
        // filter using them
        if (is_array($category)) {
            $tax_query = [
                [
                    "taxonomy" => "downloadable-files-category",
                    "field"    => "term_id",
                    "terms"    => $category,
                ]
            ];

            return get_posts([
                "post_type" => "downloadable-file",
                "posts_per_page" => -1,
                "tax_query" => $tax_query
            ]);
        }
        
        // Query with single category sent
        $tax_query = [
            [
                "taxonomy" => "downloadable-files-category",
                "field"    => "term_id",
                "terms"    => $category,
            ]
        ];
        
        return get_posts([
            "post_type" => "downloadable-file",
            "posts_per_page" => -1,
            "tax_query" => $tax_query
        ]);
    }

    public function get_selected_categories_ids() {
        return array_map(function ($e) {
            return $e->term_id;
        }, $this->file_categories_to_show);
    }
}