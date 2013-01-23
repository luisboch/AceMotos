<?php

/**
 * Description of ValidationException
 *
 * @author luis
 */
class ValidationException extends Exception
{
    /**
     *
     * @var List<ValidationError>
     */
    private $errors = array();

    public function __construct($message = "Errors found while executing an action", $code = 0, $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     *
     * @return List<ValidationError>
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     *
     * @return boolean
     */
    public function isEmtpy()
    {
        return count($this->errors) == 0;
    }

    public function addError($message, $field = NULL)
    {
        $err = new ValidationError($message, $field);
        $this->errors[] = $err;
    }

}

class ValidationError
{

    /**
     *
     * @var string
     */
    private $message;

    /**
     *
     * @var string
     */
    private $field;

    function __construct($message, $field = NULL)
    {
        $this->message = $message;
        $this->field = $field;
    }

    /**
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     *
     * @param string $message
     */

    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     *
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

}

?>
