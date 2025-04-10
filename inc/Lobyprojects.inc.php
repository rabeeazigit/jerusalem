<?php
class Lobyprojects
{


    public $pid;

    //Neighborhoods tab
    public $project_neighborhood;
    public $tzof_number;
    public $tabaa_number;
    public $project_entrepreneur;
    public $project_lowyer;
    public $yt;
    //Status tab
    public $project_status;

    //Galeery tab
    public $project_card_image_repeater; //gallery   project_card_image_repeater 

    //Project Details tab
    public $area_description;
    public $projects_sexy_numbers; //repeater
    public $project_external_link; //post object

    //Featured Projects
    public $auto_featured_project_selector; // true\false
    public $fetured_projects; //post object

    public function __construct()
    {
        $this->pid = get_the_ID();
        $this->yt = 'https://www.youtube.com/embed/';

        //Neighborhoods tab
        $this->project_neighborhood = get_field("project_neighborhood", $this->pid);
        $this->tzof_number = get_field("tzof_number", $this->pid);
        $this->tabaa_number = get_field("tabaa_number", $this->pid);
        $this->project_entrepreneur = get_field("project_entrepreneur", $this->pid);
        $this->project_lowyer = get_field("project_lowyer", $this->pid);
        //Status tab
        $this->project_status = get_field("project_status", $this->pid);

        //Galeery tab
        $this->project_card_image_repeater = get_field("project_card_image_repeater", $this->pid); //gallery

        //Project Details tab
        $this->area_description = get_field("area_description", $this->pid);
        $this->projects_sexy_numbers = get_field("projects_sexy_numbers", $this->pid); //repeater
        $this->project_external_link = get_field("project_external_link", $this->pid); //post object

        //Featured Projects
        $this->auto_featured_project_selector = get_field("auto_featured_project_selector", $this->pid); // true\false
        $this->fetured_projects = get_field("fetured_projects", $this->pid); //post object


    }




    public function MainHeader()
    {

        $html =
            '<div class="container-fluid px-0">
                <div class="row">
                    <div class="col">
                    ' . get_template_part("template-parts/navbar") . ' 
                </div> 
             </div>';

        return $html;
    }

    private function GetProjectStatus()
    {
        if (!$this->project_status || empty($this->project_status)) {
            return "";
        }
        
        $Status = [
            "name" => $this->project_status->name,
            "color" => get_field("project_status_color", "project-status_" . $this->project_status->term_id)
        ];
        
        return $Status;
    }


    private function Neighborhoods()
    {

        $Status = $this->GetProjectStatus() ?? null;
        $title = $this->project_neighborhood ?? null;

        $html = "<ul class='nbrhd ps-0 ps-md-5'>";
        
        if ($title && $title->post_title && !empty($title->post_title)) {
            $html .= "<li>{$title->post_title}</li>";
        }

        if ($this->tzof_number && !empty($this->tzof_number)) {
            $html .= "<li>{$this->tzof_number}</li>";
        }
        
        if ($this->tabaa_number && !empty($this->tabaa_number)) {
            $html .= "<li>{$this->tabaa_number}</li>";
        }
        
        if ($this->project_entrepreneur && !empty($this->project_entrepreneur)) {
            $html .= "<li>{$this->project_entrepreneur}</li>";
        }
        
        if ($this->project_lowyer && !empty($this->project_lowyer)) {
            $html .= "<li>{$this->project_lowyer}</li>";
        }
        
        $html .= "</ul>";
        
        $status_color = $Status['color'] ?? null;
        $status_name = $Status['name'] ?? null;
        
        
        if ($status_color && $status_name) {
            $html .= "<div class='sts_title ms-0 ms-md-5'>
                התקדמות תהליך
            </div>
            
            <div class='Status_pill'>
                <span style='background:{$status_color}' class='circle'></span>
                {$status_name}
            </div>";
        }


        return $html;
    }


    private function ProjectCarousle()
    {
        $Gallery = [];
        $Gallery_RAW = $this->project_card_image_repeater;

        if (!empty($Gallery_RAW)) {
            foreach ($Gallery_RAW as $key => $gal) {
                $gallery_source = $gal['gallery_source'];
    
                switch ($gallery_source) {
                    case 'video':
                        $Gallery[$key]['source'] = 'video';
                        $Gallery[$key]['video_src'] = $gal['youtube_video'];
                        $Gallery[$key]['video_title'] = $gal['pg_video_title'];
                        break;
    
                    case 'image':
                        $Gallery[$key]['source'] = 'image';
                        $Gallery[$key]['image_src'] = $gal['gallery_image'];
                        $Gallery[$key]['image_title'] = $gal['pg_image_title'];
                        break;
                }
            }
        }
        return $Gallery;
    }

    private function HTMLGallery()
    {
        $html = "";
        $Gallery = $this->ProjectCarousle();

        if ($Gallery && !empty($Gallery)) {
            foreach ($Gallery as $gal) {

                if ($gal['source'] == 'video') {
                    $html .= "<div class='yt_video_gallery' style='z-index:99;position:relative;'>";
                    $html .= "<iframe width='100%' height='510' style='z-index:99;position:relative;border-radius:30px;'
            src='https://www.youtube.com/embed/{$gal['video_src']}?mute=1' 
            title='{$gal['video_title']}' 
            frameborder='0'
            loading='lazy'>
            </iframe>";
                    $html .= "<div class='image_title my-3'><h6>{$gal['video_title']}</h6></div></div>";
                }

                if ($gal['source'] == 'image') {
                    $html .= "<div class='image_gallery'><img class='src_image_gallery' src='{$gal['image_src']}'/>";
                    $html .= "<div class='image_title my-3'><h6>{$gal['image_title']}</h6></div></div>";
                }
            }
        }

        return $html;
    }


    public function project_Description()
    {
        $area_description = get_field("area_description", $this->pid);
        $html = "<h3 class='ps-0 ps-md-5 mt-3'>תיאור המתחם</h3>";
        $html .= "<div class='pro_desc ps-0 ps-md-5'><p>{$area_description}</p></div>";
     
        return $area_description && !empty($area_description) ? $html : "";
    }


    public function HeroSeccssion()
    {
        $html = '
    <div class="container-fluid mt-5 secssionBk session_bg_vector">
        <div class="hero-section p-md-4">
            <div class="row align-items-start">
                
                <!-- Left Column: Text Content -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 about_text">
                    <h1 class="aboutTitle ps-0 ps-md-5 display-5 fw-bold">' . get_the_title($this->pid) . '</h1>
                        <div class="list-first">
                        ' . $this->Neighborhoods() . '
                        </div>
                        ' . $this->project_Description() . '
                    
                </div>

                <!-- Right Column: Image -->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="fadeCarousle">
                    ' . $this->HTMLGallery() . '
                    </div>
                    
                </div>

        </div>

        <div class="row align-items-start">

        <!-- Left Column: Text Content -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 about_text order-2 order-md-1 my-4 my-md-0">
        
        <h6 class="ps-0 ps-md-5 display-4 fs-2 fw-bold">מידע חיצוני נוסף</h6>
                ' . $this->External_Links() . '
        </div>

        <!-- Right Column: Image -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1 order-md-2">
               ' . $this->Sexeual_Numbers() . '
        </div>

        </div>

        </div>
    </div>';

        return $html;
    }


    private function Sexeual_Numbers()
    {
        $sexy_numbers = $this->projects_sexy_numbers;
        $html = "";
        $html .= "<div class='row py-5 py-md-0'>";
        if ($sexy_numbers && is_array($sexy_numbers) && !empty($sexy_numbers)) {
            foreach ($sexy_numbers as $sn) {
                $html .= "
                <div class='col-12 col-md-4 mainTopicWrapper' data-count='{$sn['the_sexy_number']}'>
                    <span class='s_number fs-1 rubik mainTopicNumber' >
                        0
                    </span>
                    
                    <span class='s_title'>
                        {$sn['project_text_sexy_number']}
                    </span>
                </div>";
            }
        }
        $html .= "</div>";
        return $html;
    }




    private  function External_Links()
    {
        $external = $this->project_external_link;



        $html = '<div class="row row-gap-4 ms-0 ms-md-4 ">';
        if ($external && is_array($external) && !empty($external)) {
            foreach ($external as $idx => $e) {
                $html .= '<div class="col-md-8">
                        <div class="vstack justify-content-between align-items-center border rounded-4 py-2 px-3 external_links_container">
                            <div class="hstack align-items-center justify-content-between external_links_toggler collapsed" data-bs-toggle="collapse" data-bs-target="#external_collapse_' . $idx . '">
                                <div class="hstack gap-2 align-items-center">
                                    <img src="' . get_field("image", $e) . '" alt="" class="external_link_image">
    
                                    <div class="fs-6 fw-semibold">' . get_field("title", $e) . '
                                    </div>
                                </div>
    
                                <div class="justify-self-end">
                                    <img class="external_link_icon" src="' . get_template_directory_uri() . '/assets/images/down-arrow.png" style="width: 24px; height: 24px">
                                </div>
                            </div>
    
                            <div class="collapse w-100" id="external_collapse_' . $idx . '">
                                <div class="vstack my-2 gap-3">';
                foreach (get_field("links", $e) as $link) {
                    if (isset($link["link"])) :
                        $html .= '<a class="text-reset text-decoration-none external_link_container" href="' . $link["link"] . '">
                                                <div class="hstack py-3 gap-4 align-items-center justify-content-between">
                                                    <img src="' . get_template_directory_uri() . '/assets/images/link.png" style="width: 24px; height: 24px">
    
                                                    <div class="fs-6 fw-semibold">' . $link["label"] . '
                                                    </div>
    
                                                    <img src="' . get_template_directory_uri() . '/assets/images/btn-arrow-black.png" style="width: 24px; height: 24px">
                                                </div>
                                            </a>';
                    endif;
                }
                $html .= '</div>
                            </div>
                        </div>
                    </div>';
            }
        }
        $html .= '</div>';

        return $html;
    }


    public function GetProjects_Random() {}

    public function should_show_featured_projects()
    {
        return $this->fetured_projects && is_array($this->fetured_projects) && count($this->fetured_projects) > 0;
    }

    public function GetProject_fetured_mnualy()
    {

        $fetured = $this->fetured_projects;
        echo '<div class="container-fluid py-4"><div class="row row-gap-5">';
        if ($fetured && is_array($fetured)) {
            foreach ($fetured as $key => $fet) {
                $e = $fet->ID;
                echo '<div class="col-md-3">';
                get_template_part("template-parts/project-card", null, [
                    "project_address" => get_field("project_address", $e) ?? null,
                    "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                    "project_status" => get_field("project_status", $e) ?? null,
                    "project_card_image" => get_field("project_card_image", $e) ?? null,
                    "project_name" => $e->post_title ?? null,
                    "project_link" => get_permalink($e) ?? null,
                ]);
                echo '</div>';
            }
        }
        echo '</div></div>';
    }
} //END CLASS
