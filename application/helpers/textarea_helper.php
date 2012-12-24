<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$_textarea_id = 0;
if (!function_exists('textarea')) {
    import('util/PHPEL.php');
    $_textarea_id = 0;
    function textarea($value,$name=NULL,$options = array(), $id = NULL) {
        global $_textarea_id;
        if($id == null){
            $id = 'text_area:'.$_textarea_id;
            $_textarea_id++;
        }
        $options['class'] = 'ui-text-area '.$options['class'];
        $opts = getOptions($options);
        return '<textarea '.$opts.' name="'.$name.'" >'.$value.'</textarea>';
    }

}
?>
