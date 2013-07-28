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
    
    /**
     *
     * @var Logger
     */
    private static $logger;
    
    function __construct() {
        parent::__construct();
        import('services/ProductService.php');
        $this->service = new ProductService();
        self::$logger = Logger::getLogger(__CLASS__);
    }

    
    public function who() {
        $produts = $this->service->getIndexProducts();
        $arr['products'] = $produts;
        $this->clientView('who.php', $arr );
        
    }
    
    protected function checkLogin() {
        return false;
    }
    
    public function view(){
        
        
        $view = $this->uri->segment(3);
        
        if($view != ''){
            try{
                $this->clientView($view);
            } catch (Exception $ex){
                self::$logger->error($ex->getMessage(), $ex);
                $this->index();
            }
        } else {
            $this->index();
        }
    }
}

?>
