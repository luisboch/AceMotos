<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Products
 *
 * @author luis
 */
class Products extends LC_Controller{
    function __construct() {
        parent::__construct();
    }

    
    public function index(){
        show_404();
    }
    
    protected function checkLogin() {
        return false;
    }
}

?>
