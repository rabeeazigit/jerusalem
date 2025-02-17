<?php

class SingleArticle
{
    public $page_title;
    public $article_date;
    public $article_description;
    public $detailed_content;
    public $related_articles_title;
    public $related_articles;

    public function __construct()
    {
        $this->page_title = get_the_title() ?? null;
        $this->article_date = get_field("article_date") ?? null;
        $this->article_description = get_field("article_description") ?? null;
        $this->detailed_content = get_field("detailed_content") ?? null;
        $this->related_articles_title = get_field("related_articles_title") ?? null;
        $this->related_articles = get_field("related_articles") ?? null;

        wp_enqueue_style(
            "single_article_styles",
            get_template_directory_uri() . "/assets/css/single-article.css",
            ["main_css"],
            filemtime(get_template_directory() . "/assets/css/single-article.css"),
            "all"
        );

        wp_enqueue_script(
            "single_article_script",
            get_template_directory_uri() . "/assets/js/single-article.js",
            ["jquery_cdn"],
            filemtime(get_template_directory() . "/assets/js/single-article.js"),
            "all"
        );
    }

    public function get_dynamic_template($item)
    {
        $fc_layout = $item["acf_fc_layout"] ?? null;
        $value = $item["value"] ?? null;

        get_template_part("template-parts/flex-content/{$fc_layout}", null, $value);
    }
}
