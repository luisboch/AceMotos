<?php

/**
 * Description of Admin
 *
 * @author luis
 */
class Admin extends LC_Controller {
    private $log;
    function __construct() {
        parent::__construct();
        $this->log = Logger::getLogger(__CLASS__);
        $this->addWay("Admin", "Admin");
    }
    
    public function index() {
        $this->adminView('index_page.php');
    }

}

?>
