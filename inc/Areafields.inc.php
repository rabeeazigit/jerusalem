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

    public function __construct()
    {
        $this->pid = get_the_ID() ;
        $this->bk_sec_about = get_field('bk_sec_about', $this->pid);
        $this->hero_section = get_field('area_fields_hero_section', $this->pid);
        $this->main_area_fields = get_field('main_area_fields', $this->pid);
         $this->community_field_title = get_field('community_field_title', $this->pid);
         $this->community_field_content = get_field('community_field_content', $this->pid);
         $this->arie_fields_connection =  get_field('arie_fields_connection', $this->pid);
    }

public function LeftSideCats(){
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


public function Get_Pills_Content(){

$html =
        '<div class="container px-0">
           
                <h2>'.  $this->community_field_title .'<h2>
                
                <div class="community_field_content">'.  $this->community_field_content .'</div>
               
           
         </div>';

return $html;
}


private function GET_AreaFieldsTermsPosts($term_id){


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





public function GetPillsCategories(){
$cats = $this->FetchAreaFiedlsCategories();
$html = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">';
$terms = [];
foreach($cats as $cat){
    $term_id = $cat->term_id;
    
    $html .= ' <li class="nav-item" 
    role="presentation">
    <button class="small-button rounded-pill  m-2" id="pills-'.$term_id.'-tab" 
    data-bs-toggle="pill" data-bs-target="#pills-'.  $term_id . '" 
    type="button" role="tab" aria-controls="pills-'.  $term_id . '" 
    aria-selected="true">'.$cat->name.'</button>
  </li>';

$terms[$term_id] = $this->GET_AreaFieldsTermsPosts($term_id);


}
$html .='</ul>';

// $html .='<div class="tab-content" id="pills-tabContent">
//   <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">...</div>
//   <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">...</div>
//   <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">...</div>
//   <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">...</div>
// </div>';



$html .= $this->Get_Pills_Content();

print_r($terms);

return $html;

}




}//==========END CLASS
