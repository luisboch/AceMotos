<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('inputpass')) {
    $_inputtext_id = 0;

    function inputpass($name = NULL, $options = array(), $id = NULL)
    {
        global $_inputtext_id;
        $_inputtext_id++;
        $id = $id === NULL ? $id = 'inputtext_' . $_inputtext_id : $id;


        $options['class'] = 'ui-state-default ui-corner-all ui-input-text ui-inputfield ui-input-pass ' . $options['class'];
        $opts = getOptions($options);
        return '<input id="' . $id . '" ' . $opts . ' name="' . $name . '" type="password" value=""/>
            ';
    }

}
?>
