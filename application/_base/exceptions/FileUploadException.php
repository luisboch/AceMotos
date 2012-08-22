<?php 
/**
 * This Exception is throwed on a fail to upload ;
 * @author luis
 */
class FileUploadException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}

?>
