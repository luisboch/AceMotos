<?php 


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('adminimage')) {
    import('util/PHPEL.php');

    function adminimage(WebImage $img = NULL, $size = 1) {
        if($img!= NULL){
            return '<div><div class="ui-image-admin"><a href="#" rel="'.URL_IMAGES.$img->getImage(5)->getLink().'" ></a><img src="'.URL_IMAGES.$img->getImage($size)->getLink().'" /><span style="clear:both;"></span></div></div>';
        }
        else{
            return '<div><div class="ui-image-admin"><img src="'.URL_IMAGES.'withoutimage250.png" /><span style="clear:both;"></span></div></div>';
        }
    }

}

?>
