<?php

class ContactUs
{
    public $main_title;
    public $main_subtitle;
    public $side_image;

    public $footer_contact_title;
    public $footer_contact_information_row;

    public function __construct()
    {
        $this->main_title = get_field("main_title") ?? null;
        $this->main_subtitle = get_field("main_subtitle") ?? null;
        $this->side_image = get_field("side_image") ?? null;

        $this->footer_contact_title = get_field("footer_contact_title", "options") ?? null;
        $this->footer_contact_information_row = get_field("footer_contact_information_row", "options") ?? null;
    }
}
