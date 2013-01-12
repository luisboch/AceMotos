<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('el')) {
    import('util/PHPEL.php');

    function el($string, &$object)
    {
        return PHPEL::read($string, $object);
    }

}

?>
