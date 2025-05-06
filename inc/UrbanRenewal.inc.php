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

        wp_enqueue_style(
            "uc_style",
            get_template_directory_uri() . "/assets/css/urban-renewal-process.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/urban-renewal-process.css"),
            "all"
        );

        wp_enqueue_script(
            "uc_style",
            get_template_directory_uri() . "/assets/js/urban-renewal-process.js",
            ["jquery_cdn"],
            filemtime(get_template_directory() . "/assets/js/urban-renewal-process.js"),
        );
    }

    public function get_renewal_categories()
    {
        // CLIENT REQUEST
        // Change code to fetch manually whatever is picked in the custom fields
        $custom_categories = get_field("urban_renewal_page_urp_category") ?? [];
        
        return $custom_categories;

        // OLD CODE
        // This function returns all the urban renewal process categories
        // that are not empty
        return get_terms([
            "taxonomy" => "urban-renewal-process-category",
            "hide_empty" => true,
        ]);
    }

    public function get_urban_renewal_processes_grouped_by_stages($category)
    {

        $result = [];

        $stages = get_terms([
            "taxonomy" => "urban-renewal-stage",
            "hide_empty" => true,
        ]);

        foreach ($stages as $stage) {
            $result[$stage->name] = $this->get_urban_renewal_processes_by_stage($stage, $category);
        }

        return $result;
    }

    public function get_urban_renewal_processes_by_stage($stage, $category)
    {
        return get_posts([
            "post_type" => "urban-renewal-proces",
            "posts_per_page" => -1,
            "orderby" => "ID",
            "order" => "ASC",
            "tax_query" => [
                [
                    "taxonomy" => "urban-renewal-stage",
                    "field"    => "term_id",
                    "terms"    => $stage,
                ],
                [
                    "taxonomy" => "urban-renewal-process-category",
                    "field"    => "term_id",
                    "terms"    => $category,
                ]
            ]
        ]);
    }

    public function get_urban_renewal_processes($category = null)
    {
        if (!$category) {
            return get_posts([
                "post_type" => "urban-renewal-proces",
                "posts_per_page" => -1,
                "orderby" => "ID",
                "order" => "ASC"
            ]);
        }

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

    public function get_dynamic_template($stage)
    {
        $fc_layout = $stage["acf_fc_layout"] ?? null;
        $value = $stage["value"] ?? null;

        get_template_part("template-parts/flex-content/{$fc_layout}", null, $value);
    }
}
