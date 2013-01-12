<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('import')) {

    function import($canonicalName)
    {
        $i = APPPATH . '_base/' . $canonicalName;
        include_once $i;
    }
}
?>
