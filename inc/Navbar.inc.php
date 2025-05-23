<?php

class Navbar
{
    public $social_media_links;

    public $about_management_label;
    public $about_management_image;
    public $about_management_links;

    public $events_courses_label;
    public $events_courses_link;

    public $news_update_label;
    public $news_update_link;

    public $owner_login_label;
    public $owner_login_logo;
    public $owner_login_link;

    public $accessibility_label;
    public $accessibility_link;

    public $brand_logo;
    public $brand_label;

    public $residents_menu_label;
    public $residents_menu_cards;
    public $residents_menu_links;

    public $entrepreneurs_menu_label;
    public $entrepreneurs_menu_cards;
    public $entrepreneurs_menu_links;

    public $renewing_neighborhoods_label;
    public $renewing_neighborhoods_link;

    public $searchbar_placeholder;

    public $contact_us_label;
    public $contact_us_label_mobile;
    public $contact_us_link;

    public function __construct()
    {
        $this->social_media_links = get_field("social_media_links", "options") ?? null;

        $this->about_management_label = get_field("about_management_label", "options") ?? null;
        $this->about_management_image = get_field("about_management_image", "options") ?? null;
        $this->about_management_links = get_field("about_management_links", "options") ?? null;

        $this->events_courses_label = get_field("events_courses_label", "options") ?? null;
        $this->events_courses_link = get_field("events_courses_link", "options") ?? null;

        $this->news_update_label = get_field("news_update_label", "options") ?? null;
        $this->news_update_link = get_field("news_update_link", "options") ?? null;

        $this->owner_login_label = get_field("owner_login_label", "options") ?? null;
        $this->owner_login_logo = get_field("owner_login_logo", "options") ?? null;
        $this->owner_login_link = get_field("owner_login_link", "options") ?? null;

        $this->accessibility_label = get_field("accessibility_label", "options") ?? null;
        $this->accessibility_link = get_field("accessibility_link", "options") ?? null;

        $this->brand_logo = get_field("brand_logo", "options") ?? null;
        $this->brand_label = get_field("brand_label", "options") ?? null;

        $this->residents_menu_label = get_field("residents_menu_label", "options") ?? null;
        $this->residents_menu_cards = get_field("residents_menu_cards", "options") ?? null;
        $this->residents_menu_links = get_field("residents_menu_links", "options") ?? null;

        $this->entrepreneurs_menu_label = get_field("entrepreneurs_menu_label", "options") ?? null;
        $this->entrepreneurs_menu_cards = get_field("entrepreneurs_menu_cards", "options") ?? null;
        $this->entrepreneurs_menu_links = get_field("entrepreneurs_menu_links", "options") ?? null;

        $this->renewing_neighborhoods_label = get_field("renewing_neighborhoods_label", "options") ?? null;
        $this->renewing_neighborhoods_link = get_field("renewing_neighborhoods_link", "options") ?? null;

        $this->searchbar_placeholder = get_field("searchbar_placeholder", "options") ?? null;

        $this->contact_us_label = get_field("contact_us_label", "options") ?? null;
        $this->contact_us_label_mobile = get_field("contact_us_label_mobile", "options") ?? null;
        $this->contact_us_link = get_page_by_template("page-templates/contact-us.php") ? get_permalink(get_page_by_template("page-templates/contact-us.php")) : "#";
    }

    public function get_mobile_menus()
    {
        if ($this->residents_menu_label) {
            $residents_menu_item = [
                "label" => $this->residents_menu_label,
                "links" => []
            ];

            if ($this->residents_menu_cards && is_array($this->residents_menu_cards)) {
                foreach ($this->residents_menu_cards as $e) {
                    if (isset($e["link"])) {
                        $residents_menu_item["links"][] = $e["link"];
                    }
                }
            }

            if ($this->residents_menu_links && is_array($this->residents_menu_links)) {
                foreach ($this->residents_menu_links as $e) {
                    if (isset($e["link"]) && isset($e["label"])) {
                        $residents_menu_item["links"][] = [
                            "title" => $e["label"],
                            "url" => $e["link"]
                        ];
                    }
                }
            }
        }

        if ($this->entrepreneurs_menu_label) {
            $enterpreneurs_menu_item = [
                "label" => $this->entrepreneurs_menu_label,
                "links" => []
            ];

            if ($this->entrepreneurs_menu_cards && is_array($this->entrepreneurs_menu_cards)) {
                foreach ($this->entrepreneurs_menu_cards as $e) {
                    if (isset($e["link"])) {
                        $enterpreneurs_menu_item["links"][] = $e["link"];
                    }
                }
            }

            if ($this->entrepreneurs_menu_links && is_array($this->entrepreneurs_menu_links)) {
                foreach ($this->entrepreneurs_menu_links as $e) {
                    if (isset($e["link"]) && isset($e["label"])) {
                        $enterpreneurs_menu_item["links"][] = [
                            "title" => $e["label"],
                            "url" => $e["link"]
                        ];
                    }
                }
            }

            if ($this->renewing_neighborhoods_label && $this->renewing_neighborhoods_link) {
                $renewing_menu_item = [
                    "label" => $this->renewing_neighborhoods_label,
                    "links" => [
                        [
                            "title" => $this->renewing_neighborhoods_label,
                            "url" => $this->renewing_neighborhoods_link
                        ]
                    ]
                ];
            }
        }

        if ($this->about_management_label) {
            $about_menu_item = [
                "label" => $this->about_management_label,
                "links" => []
            ];

            if ($this->about_management_links) {
                foreach ($this->about_management_links as $e) {
                    $about_menu_item["links"][] = $e["link"];
                }
            }
        }

        if ($this->events_courses_label) {
            $events_courses_menu_item = [
                "label" => $this->events_courses_label,
                "links" => [
                    [
                        "title" => $this->events_courses_label,
                        "url" => $this->events_courses_link
                    ]
                ]
            ];
        }

        if ($this->news_update_label) {
            $news_update_menu_item = [
                "label" => $this->news_update_label,
                "links" => [
                    [
                        "title" => $this->news_update_label,
                        "url" => $this->news_update_link
                    ]
                ]
            ];
        }

        $result = [$residents_menu_item, $enterpreneurs_menu_item, $renewing_menu_item, $about_menu_item, $events_courses_menu_item, $news_update_menu_item];
        return $result;
    }
}
