<?php

/**
 * Description of ClientController
 *
 * @author Luis
 */
class ClientController extends LC_Controller{
    private $timezones;
    function __construct() {
        parent::__construct();
        import('services/ClientService.php');
        import('util/TimeZoneUtil.php');
        
        $this->timezones = TimeZoneUtil::getAvaliableCities();
    }
    
    protected function checkLogin() {
        return false;
    }
    
    public function index() {
        echo '<pre>';
        print_r($this->timezones);
        exit;
    }
}

?>
