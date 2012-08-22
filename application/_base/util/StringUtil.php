<?php

/**
 * Description of StringUtil
 *
 * @author luis
 * @since Jul 28, 2012
 */
class StringUtil {

    public static function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endswith($haystack, $needle) {
        $strlen = strlen($haystack);
        $testlen = strlen($needle);
        if ($testlen > $strlen)
            return false;
        $bool = substr_compare($haystack, $needle, -$testlen) === 0;
        return $bool;
    }
    
    public static function toFloat($value){
        return str_replace(',', '.',str_replace('.', '', $value));
    }

}

?>
