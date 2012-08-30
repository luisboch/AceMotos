<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('select')) {
    $_select_id = 0;

    /**
     * 
     * @global int $_select_id
     * @param array $values
     * @param string $name
     * @param mixed $value
     * @param array $options
     * @param integer $id
     * @param boolean $aceptNull
     * @return string select estilized with jQueryUi
     */
    function select($values = array(), $name = NULL, $value = NULL, $options = array(), $id = NULL, $aceptNull = false) {
        global $_select_id;
        $_select_id++;
        $id = $id === NULL ? $id = 'select_' . $_inputtext_id : $id;
        $opts = '';

        $options['class'] = 'ui-select ' . $options['class'];


        foreach ($options as $k => $v) {
            $opts .= $k . '="' . $v . '" ';
        }
        $str = '<select id="' . $id . '" ' . $opts . ' name="' . $name . '" >
            ';
        if ($aceptNull) {
            $str.= '<option value="">  selecione  </option>';
        }
        $str .= generateOptions($values, $value);
        $str .= '</select>';
        return $str;
    }

    function generateOptions($values = array(), $value = '') {
        $opts = '';
        foreach ($values as $k => $v) {
            if (is_array($v)) {
                $opts .= '<optgroup>' . $k . '</optgroup>';
                $opts .= generateOptions($v, $value);
            } else {
                $opts.= '<option ' . ($value == $k ? 'selected="selected" ' : '') . 'value="' . $k . '">' . $v . '</option>';
            }
        }
        return $opts;
    }

}
?>
