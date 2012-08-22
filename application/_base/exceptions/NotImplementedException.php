<?php

/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 14, 2012 
 */
class NotImplementedException extends Exception{
    function __construct($message = "Call in method not implemented", 
            $code = NULL, Exception $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }
}

?>
