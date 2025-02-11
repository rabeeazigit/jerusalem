<?php 
class Lobyprojects {

public function __construct() {
  
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


}//END CLASS
?>