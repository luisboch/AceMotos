<?php

/**
 * Used to load produtos to clients view.
 *
 * @author luis
 */
class Products extends LC_Controller {

    /**
     * @var Logger 
     */
    private static $log;

    function __construct() {
        parent::__construct();
        import("util/StringUtil.php");
        import('services/ProductService.php');
        $this->service = new ProductService();
        self::$log = Logger::getLogger(__CLASS__);
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

    public function viewCategory() {

        import('services/CategoryService.php');
        $cId = $this->uri->segment(3);

        // Retrieve results
        self::$log->info("Loading products of Category{id: " + $cId + "}");
        $categoryService = new CategoryService();
        $category = $categoryService->getById($cId);
        $products = $this->service->getProductsByCategory($category);
        self::$log->info("Found " . sizeof($products) . " products");

        // Assing vars
        $arr['products'] = &$products;
        $arr['category'] = &$category;

        // Load View
        $this->clientView('viewCategory.php', $arr);
    }

    public function search() {

        $search = $_GET['q'];
        // Ignora o texto default da pesquisa.
        $search = $search == 'faça sua busca...' ? "" : $search;
        // Retrieve results
        self::$log->info("Search products by \"" . $search . "\"");
        $products = $this->service->viewSearch($search);
        self::$log->info("Found " . sizeof($products) . " products");

        // Assing vars
        $arr['products'] = &$products;
        $arr['searchString'] = $search;
        // Load View
        $this->clientView('viewSearch.php', $arr);
    }

}

?>
