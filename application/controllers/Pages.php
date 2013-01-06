<?php

/**
 * Description of Pages
 *
 * @author luis
 */
class Pages extends LC_Controller{
    /**
     *
     * @var ProductService
     */
    protected $service;
    function __construct() {
        parent::__construct();
        import('services/ProductService.php');
        $this->service = new ProductService();
    }

    
    public function who() {
        $produts = $this->service->getIndexProducts();
        $arr['products'] = $produts;
        $this->clientView('who.php', $arr );
        
    }
    
    protected function checkLogin() {
        return false;
    }
    
}

?>
