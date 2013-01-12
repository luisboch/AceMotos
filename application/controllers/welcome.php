<?php

/**
 * Description of Welcome
 *
 * @author luis
 */
class Welcome extends LC_Controller
{

    function __construct()
    {
        parent::__construct();
        import('services/ProductService.php');
        $this->service = new ProductService();
    }

    public function index()
    {
        $arr['products'] = $this->service->getIndexProducts();
        $this->clientView('index.php', $arr);
    }

    protected function checkLogin()
    {
        return false;
    }

}

?>
