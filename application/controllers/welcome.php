<?php
/**
 * Description of Welcome
 *
 * @author luis
 */
class Welcome extends LC_Controller{
    function __construct() {
        parent::__construct();
        $this->addWay(__CLASS__, 'Welcome');
    }

    public function canvas(){
        $this->addWay(__CLASS__.'/canvas/'.$this->uri->segment(3), 'Canvas');
        $this->adminView('canvas_'.$this->uri->segment(3).'.html');
    }
    
    protected function checkLogin() {
        return true;   
    }
}

?>
