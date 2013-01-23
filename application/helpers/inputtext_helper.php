<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$_inputtext_id;
if (!function_exists('inputtext')) {
    $_inputtext_id = 0;

    function inputtext($value, $name = NULL, $options = array(), $id = NULL)
    {
        global $_inputtext_id;
        $_inputtext_id++;
        $id = $id === NULL ? $id = 'inputtext_' . $_inputtext_id : $id;
        $opts = '';

        $options['class'] = 'ui-state-default ui-corner-all ui-input-text ui-inputfield ' . $options['class'];


        foreach ($options as $k => $v) {
            $opts .= $k . '="' . $v . '" ';
        }
        return '<input id="' . $id . '" ' . $opts . ' name="' . $name . '" type="text" value="' . $value . '"/>
            ';
    }

}
?>
