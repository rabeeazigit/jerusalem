<?php

class Areafields
{
    private $bk_sec_about;
    private $hero_image;
    private $hero_section;
    private $main_area_fields;
    private $arie_fields_connection ;
    private $community_field_title;
    private $community_field_content;
    private $community_field_title_accotdion ;

    public function __construct()
    {
        $this->pid = get_the_ID() ;
        $this->bk_sec_about = get_field('bk_sec_about', $this->pid);
        $this->hero_section = get_field('area_fields_hero_section', $this->pid);
        $this->main_area_fields = get_field('main_area_fields', $this->pid);
        $this->community_field_title = get_field('community_field_title', $this->pid);
        $this->community_field_content = get_field('community_field_content', $this->pid);
        $this->arie_fields_connection =  get_field('arie_fields_connection', $this->pid);
        $this->community_field_title_accotdion =  get_field('community_field_title_accotdion', $this->pid);

    }

    public function LeftSideCats()
    {
        return  $this->hero_section['bk_sec_about'];
    }






    public function HeroSeccssion()
    {


        //print_r($this->hero_section);

        $html = '
                <div class="container-fluid mt-5 secssionBk">
                        <div class="hero-section p-4">
                            <div class="row align-items-start">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 about_text ">
                                    <h1 class="aboutTitle display-4 fw-bold">'.get_the_title(get_the_ID()).'</h1>
                                    <span class="fs-5">'.$this->hero_section['about_content'].'</span><br></div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <img src="'.$this->hero_section['hero_image'].'" alt="" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>';

        return $html;
    }


    public function MainHeader()
    {

        $html =
                '<div class="container-fluid px-0">
                    <div class="row">
                        <div class="col">
                        '. get_template_part("template-parts/navbar") . ' 
                    </div> 
                 </div>';

        return $html;
    }




    public function Get_AreaFieldsPosts()
    {
        $args = array(
            'post_type'      => 'area-fields', // Custom post type name
            'numberposts'    => -1,            // Retrieve all posts
            'post_status'    => 'publish',     // Only published posts
        );
        $posts = get_posts($args);
        return $posts;
    }

    public function FetchAreaFiedlsCategories()
    {
        $categories = get_terms([
            'taxonomy'   => 'category', // Default WordPress category taxonomy
            'hide_empty' => true, // Show all categories, even if they have no posts
            'object_ids' => get_posts([
                'post_type'      => 'area-fields',
                'posts_per_page' => -1,
                'fields'         => 'ids', // Fetch only post IDs
            ]),
        ]);
        return  $categories ;
    }


    public function Get_Pills_Content()
    {

        $html =
                '<div class="container px-0">
           
                <h2>'.  $this->community_field_title .'<h2>
                
                <div class="community_field_content">'.  $this->community_field_content .'</div>
               
           
         </div><p>'.$this->community_field_title_accotdion.'</p>';

        return $html;
    }


    private function GET_AreaFieldsTermsPosts($term_id)
    {

        $posts_raw = [];
        $args = array(
            'post_type'      => 'area-fields',
            'posts_per_page' => -1, // Fetch all posts
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category', // Replace with your actual taxonomy name
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ),
            ),
        );

        $posts = get_posts($args);
        return $posts;
    }



    private function BootsrapAccordion($terms)
    {
        //$terms Needs to be an array....

        $html = '<div class="accordion" id="accordionPanelsfields">';


        foreach ($terms as $post) {
            $GroupContent = $this->GetAccordionContent($post->ID);
            //area_sticky_image
            $sticky =  $GroupContent['area_sticky_image']  == 1 ? 'class="img-fluid position-sticky" style="top: 20px;" ' : 'style="width:100%;"';
            $html .= ' 
<div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#panelsStayOpen-collapse'.$post->ID.'" 
                aria-expanded="true" 
                aria-controls="panelsStayOpen-collapse'.$post->ID.'" >
        '.$post->post_title.'
      </button>
    </h2>
    <div id="panelsStayOpen-collapse'.$post->ID.'"  class="accordion-collapse collapse" data-bs-parent="#accordionPanelsfields">
      <div class="accordion-body">
       <h1>'. $GroupContent['area_title'] . '</h1>
                <div class="container">
                <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="GroupContent">'. $GroupContent['area_content'] . '</div>
                </div>
                <div class="col-lg-4 col-sm-12 position-relative"><img src="'. $GroupContent['area_image'] .' " loading="lazy" '.$sticky.'/>
                </div>
                
                </div>
                </div>

        </div>
    </div>
  </div>
  ';

        }



        $html .= '</div>' ; //Closer Accordion
        return $html;
    }



    private function GetAccordionContent($pid)
    {
        $LayOut = [];
        $content = get_field('main_area_fields', $pid);
        $LayOut['area_title'] = $content[0]['area_title'];
        $LayOut['area_content'] = $content[0]['area_content'];
        $LayOut['area_image'] = $content[0]['area_image']['url'];
        $LayOut['area_sticky_image'] = $content[0]['area_sticky_image'];

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

            $term_id = $cat->term_id;

            $html .= ' <li class="nav-item" 
    role="presentation">
    <button class="small-button rounded-pill '.$active_class.'  m-2" id="pills-'.$term_id.'-tab" 
    data-bs-toggle="pill" data-bs-target="#pills-'.  $term_id . '" 
    type="button" role="tab" aria-controls="pills-'.  $term_id . '" 
    aria-selected="true">'.$cat->name.'</button>
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

            $randomNumber = mt_rand(5221, 1000000);

            if ($cnt == 0) {
                $active_class = 'show active';
            } else {
                $active_class = '';
            }
            $html .= ' <div class="tab-pane fade '.$active_class.'" id="pills-'.$key.'" role="tabpanel" aria-labelledby="pills-'.$key.'-tab" tabindex="0">';
            $html .= $this->BootsrapAccordion($terminis);

            $html .= '</div>';
            $cnt++;
        }



        $html .= '</div>'; //tab closer


        //print_r($terms);

        return $html;

    }




}//==========END CLASS
