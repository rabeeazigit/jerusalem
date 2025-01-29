<?php

class About
{
    private $about_content;
    private $tagd_links;
    private $about_sexy_numbers;
    private $aoa_title;
    private $aoa_content;
    private $main_topic_options;
    private $our_staff;
    private $hero_image;
    private $bk_sec_about;
    private $bk_sec_activities;
    private $pid ;



    public function __construct()
    {
        $this->pid = get_the_ID() ;
        $this->about_content = get_field('about_content', $this->pid);
        $this->tagd_links = get_field('tagd_links', $this->pid);
        $this->about_sexy_numbers = get_field('about_sexy_numbers', $this->pid);
        $this->aoa_title = get_field('aoa_title', $this->pid);
        $this->aoa_content = get_field('aoa_content', $this->pid);
        $this->main_topic_options = get_field('main_topic_options', $this->pid);
        $this->our_staff = get_field('our_staff', $this->pid);
        $this->hero_image = get_field('hero_image', $this->pid);
        $this->bk_sec_about = get_field('bk_sec_about', $this->pid);
        $this->bk_sec_activities = get_field('bk_sec_activities', $this->pid);


    }




private function TagTheFucker($tags = []){
$html = '';

foreach($tags as $key=>$tag){
//$tag[$key]['text'] =$val['tagd_links_text'];
//$tag[$key]['link'] =$val['tagd_links_url'];
$html .= "<div class='btn btn-outline-secondary rounded-pill hovertagabout m-2'>
<a href='{$tag['tagd_links_url']}' target='_BLANK'>{$tag['tagd_links_text']}</a></div>";
}

return $html;

}




    public function MainHeader()
    {

        $html = '<div class="container-fluid px-0">
            <div class="row">
                <div class="col">
                '. get_template_part("template-parts/navbar") . ' 
                </div> 
        </div>';

        return $html;
    }



    public function HeroSeccssion()
    {

        $bk = $this->bk_sec_about ? $this->bk_sec_about : '';
$tags = $this->TagTheFucker( $this->tagd_links  );
        $html = '

    <div class="container-fluid mt-5 secssionBk" style="background:url('.$bk.');">
            <div class="hero-section p-4">
                <div class="row align-items-start">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 about_text ">
                        <h1 class="aboutTitle display-4 fw-bold">'.get_the_title(get_the_ID()).'</h1>
                        <span class="fs-5">'.$this->about_content.'</span><br>';
                     
                        
                    $html .=$tags . '</div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img src="'.$this->hero_image.'" alt="" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    public function SexyNumber()
    {
        $SexyNumbers = ($this->about_sexy_numbers);

        $html = '

       <div class="container">
       <div class="row py-5 my-2">';
        foreach ($SexyNumbers as $numbers) {
            $html .=
            '<div class="col text-center text-dark">
              <div class="display-1 fw-semibold">'. $numbers['about_number'] .'</div>
              <div class="fs-5 fw-semibold">'. $numbers['about_numbers_text'] .'</div>
              </div>';
        }

        $html .= '</div></div>';

        return $html;
    }

    public function AreaOfActivities()
    {
        $bk = $this->bk_sec_activities ? $this->bk_sec_activities : '';
        get_template_part('template-parts/main-topics', null, [
            "main_topics_main_topics" => $this->main_topic_options['main_topics'] ?? null,
            "main_topics_title" => $this->aoa_title,
            "main_topics_content" => $this->aoa_content,
            "main_topics_content_class" => "apw",
            "main_topics_link" => ["text" => "לכל התחומים", "url" => "#"]
        ]);
    }

    public function OurStaff()
    {
        $Staff =  $this->our_staff ;

        $html = '
 <div class="container">
       <div class="d-flex flex-wrap align-items-center justify-content-around py-5 my-2">
';
        foreach ($Staff as $Staff) {
            $html .= 
            '<div class="col-lg-3 mb-5">
                        <div class="staff_photo"><img src="'.$Staff['staff_member_photo'].'" loading="lazy"/>
                        </div>
                        <div class="container cont_det">
                        <div class="row">
                        <div class="col-12 fs-5 fw-bold">'.$Staff['staff_member_name'].'</div>
                       
                        <div class="col-12">'.$Staff['staff_member_role'].'</div>
                        <div class="col-12"><span><span><img src="'. get_template_directory_uri().'/assets/images/about/email-icon.png" /></span>'.$Staff['staff_member_email'].'</span></div>
                        </div>
                        </div>

            </div>';
        }

        $html .= '</div></div>';

        return $html;

    }



}//END OF CLASS
