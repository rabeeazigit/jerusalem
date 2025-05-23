<?php
class SingleProject
{


    public $pid;

    //Neighborhoods tab
    public $project_neighborhood;
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

    public $project_external_link_group;

    //Featured Projects
    public $auto_featured_project_selector; // true\false
    public $fetured_projects; //post object

    public function __construct()
    {
        $this->pid = get_the_ID();
        $this->yt = 'https://www.youtube.com/embed/';

        //Neighborhoods tab
        $this->project_neighborhood = get_field("project_neighborhood", $this->pid);
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
        $this->project_external_link_group = get_field('project_external_link_group', $this->pid);

        //Featured Projects
        $this->auto_featured_project_selector = get_field("auto_featured_project_selector", $this->pid); // true\false
        $this->fetured_projects = get_field("fetured_projects", $this->pid); //post object

        // If no projects are selected
        // Get the latest 4 projects from the same neighborhood
        if (
            (!is_array($this->fetured_projects))
            ||
            (empty($this->fetured_projects) && isset($this->project_neighborhood) && isset($this->project_neighborhood->ID))
        ) {
            $this->fetured_projects = get_posts([
                'post_type' => 'project',
                'posts_per_page' => 4,
                'exclude' => [$this->pid],
                'meta_query' => [
                    [
                        'key' => 'project_neighborhood',
                        'value' => $this->project_neighborhood->ID,
                        'compare' => '='
                    ]
                ]
            ]);
        }
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
            $html .= "<li>שם שכונה: {$title->post_title}</li>";
        }

        if ($this->tabaa_number && !empty($this->tabaa_number)) {
            $html .= '<li>מספר תוכנית: ' . $this->tabaa_number . '</li>';
        }

        if ($this->project_entrepreneur && !empty($this->project_entrepreneur)) {
            $html .= '<li>שם היזם: ' . $this->project_entrepreneur . '</li>';
        }

        if ($this->project_lowyer && !empty($this->project_lowyer)) {
            $html .= "<li> עו\"ד בעלי הדירות: {$this->project_lowyer}</li>";
        }

        $html .= "</ul>";

        $status_color = $Status['color'] ?? null;
        $status_name = $Status['name'] ?? null;


        if ($status_color && $status_name) {
            $html .= "<div class='sts_title ms-0 ms-md-5'>
                סטטוס
            </div>
            
            <div class='Status_pill'>
                <span style='background:{$status_color}' class='circle'></span>
                {$status_name}
            </div>";
        }


        return $html;
    }


    private function ProjectCarousel()
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
        $Gallery = $this->ProjectCarousel();

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
        
        
                ' . $this->External_Links() . '
        </div>

        <!-- Right Column: Image -->
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 order-1 order-md-2">
               ' . $this->RunningNumbers() . '
        </div>

        </div>

        </div>
    </div>';

        return $html;
    }


    // private function RunningNumbers()
    // {
    //     $sexy_numbers = $this->projects_sexy_numbers;
    //     $html = "";
    //     $html .= "<div class='row py-5 py-md-0'>";
    //     if ($sexy_numbers && is_array($sexy_numbers) && !empty($sexy_numbers)) {
    //         foreach ($sexy_numbers as $sn) {
    //             $html .= "
    //             <div class='col-12 col-md-4 mainTopicWrapper' data-count='{$sn['the_sexy_number']}'>
    //                 <span class='s_number fs-1 rubik mainTopicNumber' >
    //                     0
    //                 </span>

    //                 <span class='s_title'>
    //                     {$sn['project_text_sexy_number']}
    //                 </span>
    //             </div>";
    //         }
    //     }
    //     $html .= "</div>";
    //     return $html;
    // }
    private function RunningNumbers()
    {
        $existing_unit = get_field('existing_unit', $this->pid);
        $proposed_unit = get_field('proposed_unit', $this->pid);
        $process_unit = get_field('process_unit', $this->pid);

        $html = "";
        $html .= "<div class='row py-5 py-md-0'>";

        // Existing Unit
        if (!empty($existing_unit)) {
            $html .= "
                <div class='col-12 col-md-4 mainTopicWrapper' data-count='{$existing_unit}'>
                    <span class='s_number fs-1 rubik mainTopicNumber'>
                        0
                    </span>
                    <span class='s_title'>
                        יח\"ד קיים
                    </span>
                </div>";
        }

        // Proposed Unit
        if (!empty($proposed_unit)) {
            $html .= "
                <div class='col-12 col-md-4 mainTopicWrapper' data-count='{$proposed_unit}'>
                    <span class='s_number fs-1 rubik mainTopicNumber'>
                        0
                    </span>
                    <span class='s_title'>
                        יח\"ד מוצע
                    </span>
                </div>";
        }

        // Process Unit
        if (!empty($process_unit)) {
            $html .= "
                <div class='col-12 col-md-4 mainTopicWrapper' data-count='{$process_unit}'>
                    <span class='s_number fs-1 rubik mainTopicNumber'>
                        0
                    </span>
                    <span class='s_title'>
                        יח\"ד בביצוע
                    </span>
                </div>";
        }

        $html .= "</div>";
        return $html;
    }




    private  function External_Links()
    {
        $link_group = $this->project_external_link_group ?? null;
        $image = $link_group['image'] ?? null;
        $link = [
            'url' => get_field('technon_link', $this->pid) ?? null,
            'target' => '_blank',
            'title' => 'לאתר מינהל התכנון'
        ];

        ob_start(); ?>

        <?php if ($link) : ?>
            <h6 class="ps-0 ps-md-5 display-4 my-4 fs-2 fw-bold">
                מידע חיצוני נוסף
            </h6>

            <a
                class="hstack pro_desc align-items-center justify-content-between ms-md-5 ms-0
                border rounded-4 py-2 px-3 external_links_container group_item text-reset text-decoration-none"
                href="<?= $link['url'] ?? '#'; ?>"
                target="<?= $link['target'] ?? ''; ?>">
                <div class="hstack gap-2 align-items-center">
                    <?php if ($image && is_array($image)) : ?>
                        <img
                            class="external_link_image bg-white"
                            src="<?= $image['url'] ?? null; ?>"
                            alt="<?= $image['alt']; ?>"
                            title="<?= $image['title']; ?>" 
                        />
                    <?php else : ?>
                        <img 
                            class="external_link_image bg-white"
                            src="<?= get_template_directory_uri() . '/assets/images/technon_default.png'; ?>"
                            alt="מינהל התכנון"
                            title="מינהל התכנון"
                        />
                    <?php endif; ?>

                    <?php if (isset($link['title']) && !empty($link['title'])) : ?>
                        <div class="fs-6 fw-semibold">
                            <?= $link['title']; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="justify-self-end">
                    <img
                        class="external_link_icon"
                        src="<?= get_template_directory_uri() . "/assets/images/down-arrow.png"; ?>"
                        style="
                            width: 24px;
                            height: 24px;
                            transform: rotate(90deg);
                        " />
                </div>
            </a>
        <?php endif; ?>

<?php
        $html = ob_get_clean();

        return $html;
    }

    public function GetProjects_Random() {}

    public function GetProjectsToDisplay()
    {
        if (count($this->fetured_projects) <= 0) {
            return;
        }

        echo '<div class="container-fluid py-4"><div class="row row-gap-5">';
        if ($this->fetured_projects && is_array($this->fetured_projects)) {
            foreach ($this->fetured_projects as $key => $fet) {
                $e = $fet->ID;
                echo '<div class="col-md-3">';
                get_template_part("template-parts/project-card", null, [
                    "project_address" => get_field("project_address", $e) ?? null,
                    "project_neighborhood" => get_field("project_neighborhood", $e) ?? null,
                    "project_status" => get_field("project_status", $e) ?? null,
                    "project_card_image" => get_field("project_card_image", $e) ?? null,
                    "project_name" => $fet->post_title ?? null,
                    "project_link" => get_permalink($e) ?? null,
                ]);
                echo '</div>';
            }
        }
        echo '</div></div>';
    }
} //END CLASS
