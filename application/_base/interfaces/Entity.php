<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author luis
 */
interface Entity {

    /**
     * @return integer
     */
    public function getId();
    
    /**
     *@var $id integer 
     */
    public function setId($id);
    
}

?>