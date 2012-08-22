<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('button')) {
    $_button_id = 0;

    function button($value, $link = NULL, $type = NULL, $id = NULL, $options = array()) {
        global $_button_id;
        $_button_id++;
        $options['class'] = 'ui-button '.$options['class'];
        
        $opts = getOptions($options);
        
        $id = $id === NULL ? $id = 'button_' . $_button_id : $id;
        $type = $type === NULL ? "submit" : $type;
        if($link !== null){
           return '<a id="'.$id.'" href="'.$link.'" '.$opts.' >'.$value.'</a>';
        }
        return '<button id="' . $id . '" '.$opts.' >' . $value . '</button>';
    }

}
?>