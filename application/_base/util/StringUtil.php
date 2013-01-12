<?php

/**
 * Description of StringUtil
 *
 * @author luis
 * @since Jul 28, 2012
 */
class StringUtil
{

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function endswith($haystack, $needle)
    {
        $strlen = strlen($haystack);
        $testlen = strlen($needle);
        if ($testlen > $strlen)
            return false;
        $bool = substr_compare($haystack, $needle, -$testlen) === 0;
        return $bool;
    }

    /**
     * @param $value
     * @return float
     */
    public static function toFloat($value)
    {
        return floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }

    /**
     * @param $value
     * @return string
     */
    public static function currency($value)
    {
        return number_format($value, 2, ',', '.');
    }

}

?>
