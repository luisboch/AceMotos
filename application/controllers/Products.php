<?php

/**
 * Description of Products
 *
 * @author luis
 */
class Products extends LC_Controller {

    function __construct() {
        parent::__construct();
        import("util/StringUtil.php");
        import('services/ProductService.php');
        $this->service = new ProductService();
    }

    protected function checkLogin() {
        return false;
    }

    public function view() {
        try {
            $product = $this->service->getById($this->uri->segment(3));
            $arr['product'] = &$product;
            $this->clientView('product.php', $arr);
        } catch (NoResultException $e) {
            show_404();
        }
    }

}

?>
