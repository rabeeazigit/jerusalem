<?php
class About{


private $about_content;
private $tagd_links;
private $about_sexy_numbers;
private $aoa_title;
private $aoa_content;
private $aoa_activities;
private $our_staff;
private $hero_image;


public function __construct()
{
    $this->about_content = get_field('about_content', get_the_ID());
    $this->tagd_links = get_field('tagd_links', get_the_ID());
    $this->about_sexy_numbers = get_field('about_sexy_numbers', get_the_ID());
    $this->aoa_title = get_field('aoa_title', get_the_ID());
    $this->aoa_content = get_field('aoa_content', get_the_ID());
    $this->aoa_activities = get_field('aoa_activities', get_the_ID());
    $this->our_staff = get_field('our_staff', get_the_ID());
    $this->hero_image = get_field('hero_image', get_the_ID());
}


public function MainHeader(){
$html = '<div class="container-fluid px-0">
            <div class="row">
                <div class="col">
                '. get_template_part("template-parts/navbar") . ' 
                </div> 
        </div>';

        return $html;
}



public function HeroSeccssion(){
$html = '

    <div class="container-fluid mt-5 ">
            <div class="hero-section p-4">
                <div class="row align-items-start">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 about_text ">
                        <h1 class="aboutTitle">'.get_the_title(get_the_ID()).'</h1>
                        <span>'.$this->about_content.'</span>
                        
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img src="'.$this->hero_image.'" alt="" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>';

return $html;
}

public function SexyNumber(){
    $SexyNumbers = ($this->about_sexy_numbers);
    $html = '

       <div class="container">
       <div class="row">';
       foreach($SexyNumbers as $numbers){
              $html .= 
              '<div class="col text-center">
              <p>'. $numbers['about_number'] .'</p>
              <p>'. $numbers['about_numbers_text'] .'</p>
              </div>';
       }
       
$html .= '</div></div>';

return $html;
}



}
?>