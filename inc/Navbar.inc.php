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
    }
}
