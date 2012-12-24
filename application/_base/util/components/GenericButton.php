<?php

/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 15, 2012 
 */
class GenericButton {

    const ACTION_JAVASCRIPT = 1;
    const ACTION_FORMSUBMIT = 2;
    const ACTION_HREF = 3;

    private static $_S;
    private $href = '';
    private $value;
    private $id;
    private $type;

    function __construct($href = 'javascript:void(0);',
            $id = NULL, $type = self::ACTION_HREF) {
        $this->href = $href;
        if (self::$_S == '') {
            self::$_S = 1;
        }
        if ($id === NULL) {
            $id = "button_";
        }
        $this->id = $id . self::$_S;
        self::$_S++;

        $this->type = $type;
    }

    /**
* @param type $return boolean
* @return string
*/
    public function generate($return = FALSE) {
        if ($this->type == self::ACTION_FORMSUBMIT) {
            $r = '<input type="submit" class="button" value="' . $this->value .
                    '" id="' . $this->id . '">';
        } else {
            
            $r = '<a href="'.$this->href.'" class="button" id="' . $this->id . '">'.$this->value.'</a>';
        }
        if ($return) {
            return $r;
        } else {
            echo $r;
        }
    }

    public function getHref() {
        return $this->href;
    }

    public function setHref($href) {
        $this->href = $href;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getId() {
        return $this->id;
    }

}


?>
