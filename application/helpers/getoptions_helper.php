<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('getOptions')) {
    function getOptions($options){
        $opts = '';
        foreach($options as $k => $v){
            $opts .= $k.'="'.$v.'" ';
        }
        return $opts;
    }
}

?>
