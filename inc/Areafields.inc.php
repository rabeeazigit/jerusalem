<?php

class Areafields
{
    private $bk_sec_about;
    private $hero_image;
    private $hero_section;
    private $main_area_fields;
    private $arie_fields_connection;
    private $community_field_title;
    private $community_field_content;
    private $community_field_title_accotdion;
    private $pid;
    public function __construct()
    {
        $this->pid = get_the_ID();
        $this->bk_sec_about = get_field('bk_sec_about', $this->pid);
        $this->hero_section = get_field('area_fields_hero_section', $this->pid);
        $this->main_area_fields = get_field('main_area_fields', $this->pid);
        $this->community_field_title = get_field('community_field_title', $this->pid);
        $this->community_field_content = get_field('community_field_content', $this->pid);
        $this->arie_fields_connection = get_field('arie_fields_connection', $this->pid);
        $this->community_field_title_accotdion = get_field('community_field_title_accotdion', $this->pid);

        wp_enqueue_script(
            "area-fields-js",
            get_template_directory_uri() . "/assets/js/area-fields.js",
            [],
            filemtime(get_template_directory() . "/assets/js/area-fields.js")
        );
    }

    public function LeftSideCats()
    {
        return $this->hero_section['bk_sec_about'] ?? null;
    }


    public function HeroSeccssion()
    {
        // Capture breadcrumbs output
        $breadcrumbs = "";
        if (function_exists("yoast_breadcrumb")) {
            ob_start();
            ?>
            <div class="sq_breadcrumbs pb-5 fs-5">
                <?php yoast_breadcrumb(); ?>
            </div>
            <?php
            $breadcrumbs = ob_get_clean();
        }

        // Capture the entire HTML output using output buffering
        ob_start();
        ?>
        <div class="container-fluid mt-5 secssionBk">
            <div class="hero-section p-md-4 p-3">
                <div class="row align-items-start">

                    <div class="col-12"><?= $breadcrumbs; ?></div>

                    <!-- Left Column: Text Content -->
                    <div class="col-xl-6 col-lg-12 about_text">
                        <h1 class="aboutTitle display-4 fw-bold"><?= get_the_title($this->pid); ?></h1>
                        <span class="fs-5"><?= $this->hero_section['about_content'] ?? ''; ?></span>
                        <br />
                    </div>

                    <!-- Right Column: Image -->
                    <?php if ($this->hero_section['hero_image']): ?>
                        <div class="col-xl-6 col-lg-12">
                            <img src="<?= $this->hero_section['hero_image'] ?? ''; ?>" alt="Hero Image" class="img-fluid rounded">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
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




    public function Get_AreaFieldsPosts()
    {
        $args = array(
            'post_type' => 'area-fields', // Custom post type name
            'numberposts' => -1,            // Retrieve all posts
            'post_status' => 'publish',     // Only published posts
        );
        $posts = get_posts($args);
        return $posts;
    }

    public function FetchAreaFiedlsCategories()
    {
        $cats = get_field('arie_fields_connection', $this->pid);
        
        $result = array_map(function ($e) {
            return $e->ID;
        }, $cats);

        return $result;
        
        $categories = get_terms([
            'taxonomy' => 'category', // Default WordPress category taxonomy
            'hide_empty' => false,      // Show all categories, even if they have no posts
            'order'      => 'DESC',   // Order categories in descending order
            'object_ids' => get_posts([
                'post_type' => 'area-fields',
                'posts_per_page' => -1,
                'fields' => 'ids', // Fetch only post IDs
            ]),
        ]);
        
        return $categories;
    }


    public function Get_Pills_Content()
    {

        $html =
            '<div class="container px-0">
           
                <h2>' . $this->community_field_title . '<h2>
                
                <div class="community_field_content">' . $this->community_field_content . '</div>
               
           
         </div><p>' . $this->community_field_title_accotdion . '</p>';

        return $html;
    }


    private function GET_AreaFieldsTermsPosts($term_id)
    {
        // $data = get_field('', $term_id);
        $args = array(
            'post_type' => 'area-fields',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'ID' => $term_id
        );

        $posts = get_posts($args);
        return $posts;
    }

    private function BootsrapAccordion($terms)
    {
        $html = '<div class="" id="accordionPanelsfields">';
    
        foreach ($terms as $post) {
    
            $GroupContent = $this->GetAccordionContent($post->ID);
    
            //area_sticky_image
            $sticky = $GroupContent['area_sticky_image'] == 1 ? 'class="img-fluid position-sticky" style="top: 20px;" ' : 'style="width:100%;"';
            $sec1Args = array(
                'all_fields' => $GroupContent['all_fields'],
                'all_fields_title' => $GroupContent['all_fields_title'],
                'area_title' => $GroupContent['area_title'],
                'area_content' => $GroupContent['area_content'],
                'area_  image' => $GroupContent['area_image'],
                'area_more_btn' => $GroupContent['area_more_btn'] ?? '',
                'sticky' => $sticky
            );
    
            $pid = $GroupContent['pid'];
    
            // Display post title and content without accordion
            $html .= '<div class=" mb-3">';
            $html .= '<div class=" fw-bold fs-3">' . $post->post_title . '</div>';
            $html .= '<div class=""style="font-size:18px;font-weight:400">' . $GroupContent['area_content'] . '</div>';

    
            // Repeater Field Accordion
            if (!empty($GroupContent['all_fields']) && is_array($GroupContent['all_fields'])) {

                $html .= '<div class="accordion" id="accordionRepeater' . $post->ID . '">';
                 $html .= '<div class=" fw-bold fs-5 mt-4 mb-3">' . $GroupContent['all_fields_title']. '</div>';
                foreach ($GroupContent['all_fields'] as $index => $field) {
                    $field_title = $field['title'] ?? '';
                    $field_desc = $field['desc'] ?? '';
    
                    $html .= '<div class="accordion-item">';
                    $html .= '<h2 class="accordion-header">';
                    if (empty(trim($field_desc))) {
                        // Show header without collapse button
                        $html .= '<div class="accordion-button disabled">' . $field_title . '</div>';
                    } else {
                        // Show header with collapse button
                        $html .= '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#repeater-collapse' . $post->ID . '-' . $index . '" aria-expanded="false">';
                        $html .= $field_title;
                        $html .= '</button>';
                        $html .= '<div id="repeater-collapse' . $post->ID . '-' . $index . '" class="accordion-collapse collapse">';
                        $html .= '<div class="accordion-body" style="font-size:18px;font-weight:400">' . $field_desc . '</div>';
                        $html .= '</div>';
                    }
                    $html .= '</h2></div>'; // Close accordion-item
                }
    
                $html .= '</div>'; // End of repeater accordion
            }
    
            $html .= '</div>'; // End of main item
        }
    
        $html .= '</div>'; // Close accordion container
        return $html;
    }
    


    private function GetAccordionContent($pid)
    {
        $LayOut = [];
        $content = get_field('main_area_fields', $pid); //GROUP ACF
        
        if (isset($content[0])) {
            $LayOut['area_title'] = $content[0]['area_title'] ?? '';
            $LayOut['area_content'] = $content[0]['area_content'] ?? '';
            $LayOut['all_fields'] = $content[0]['all_fields'] ?? [];
            $LayOut['all_fields_title'] = $content[0]['all_fields_title'] ?? '';
            $LayOut['area_image'] = $content[0]['area_image']['url'] ?? '';
            $LayOut['area_sticky_image'] = $content[0]['area_sticky_image'] ?? '';
            $LayOut['area_more_btn'] = $content[0]['area_more_btn'] ?? '';
        }
    
        if (isset($content[1])) {
            $LayOut['area_table'] = $content[1]['area_table'] ?? [];
            $LayOut['table_title'] = $content[1]['table_title'] ?? '';
        }
    
        if (isset($content[2]['area_files_download'])) {
            $LayOut['downloads'] = $content[2]['area_files_download'];
        }
    
        if (isset($content[3]['area_videos'])) {
            $LayOut['videos'] = $content[3]['area_videos'];
        }
    
        $LayOut['pid'] = wp_unique_id('slider_');
    
        return $LayOut;
    }
    
    public function GetPillsCategories()
    {
        $cats = $this->FetchAreaFiedlsCategories();
        $html = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">';
        $terms = [];
        $cnt = 0;
        foreach ($cats as $cat) {

            if ($cnt == 0) {
                $active_class = 'active';
            } else {
                $active_class = '';
            }

            $term_id = $cat;

            $post = get_post($term_id);
            $term_name = $post->post_title;
            
            $html .= ' <li class="nav-item" 
                            role="presentation">
                            <button class=" small-button area_field_tab_btn activeFieldLink rounded-pill ' . $active_class . '  m-2" id="pills-' . $term_id . '-tab" 
                            data-bs-toggle="pill" data-bs-target="#pills-' . $term_id . '" 
                            type="button" role="tab" aria-controls="pills-' . $term_id . '" 
                            aria-selected="true" data-term-id="' . $term_id . '">' . $term_name . '</button>
                        </li>';

            $terms[$term_id] = $this->GET_AreaFieldsTermsPosts($term_id);
            $cnt++;

        }
        $html .= '</ul>';




        $html .= $this->Get_Pills_Content();
        //$html .=$this->BootsrapAccordion($terms);


        $html .= '<div class="tab-content" id="pills-tabContent">';
        $cnt = 0;
        $active_class = '';
        foreach ($terms as $key => $terminis) {

            if ($cnt == 0) {
                $active_class = 'show active';
            } else {
                $active_class = '';
            }
            $html .= ' <div class="tab-pane fade ' . $active_class . '" id="pills-' . $key . '" role="tabpanel" aria-labelledby="pills-' . $key . '-tab" tabindex="0">';
            $html .= $this->BootsrapAccordion($terminis);

            $html .= '</div>';
            $cnt++;
        }

        $html .= '</div>'; //tab closer
        //print_r($terms);
        return $html;
    }





}//==========END CLASS
