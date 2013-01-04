<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseException
 *
 * @author luis
 */
class DaoException extends Exception {

    /**
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>
