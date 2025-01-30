<?php

class Areafields
{
    private $bk_sec_about;
    private $hero_image;
    private $hero_section;

    public function __construct()
    {
        $this->pid = get_the_ID() ;
        $this->bk_sec_about = get_field('bk_sec_about', $this->pid);
        $this->hero_section = get_field('area_fields_hero_section', $this->pid);

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



public function GetPillsCategories(){
$cats = $this->FetchAreaFiedlsCategories();
$html = '<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">';
foreach($cats as $cat){
    $html .= ' <li class="nav-item" 
    role="presentation">
    <button class="nav-link active  rounded-pill hovertagabout m-2"
     id="pills-home-tab" 
    data-bs-toggle="pill" data-bs-target="#pills-home" 
    type="button" role="tab" aria-controls="pills-home" 
    aria-selected="true">'.$cat->name.'</button>
  </li>';
}
$html .='</ul>';
return $html;

}




}//==========END CLASS
