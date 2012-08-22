<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
class ProductsController extends LC_Controller {

    
    function __construct() {
        parent::__construct();
        import("util/components/DataTable.php");
        import("util/StringUtil.php");
        import('services/ProductService.php');
        $this->service = new ProductService();
        $this->addWay(__CLASS__, 'produtos');
    }

    public function index() {
        $this->addWay(__CLASS__ . '/index', 'home');
        $this->adminView('products_index.php');
    }

    public function search() {
        $this->addWay(__CLASS__.'/search', 'pesquisa');

        $params = $this->getRequestParams(array('search' => '%', 'p' => 1));

        $currentPage = $params['p'];

        $start = Pagination::getOffset($currentPage, self::$NUMREGISTERS_PER_PAGE);

        $amout = $this->service->count(urldecode($params['search']));
        
        $products = $this->service->search(urldecode($params['search']), $start, self::$NUMREGISTERS_PER_PAGE);
        
        $dat = new DataTable(array(
                    'btSearch' => true,
                    'urlSearch' => site_url(__CLASS__),
                    'btCreate' => true,
                    'urlCreate' => site_url(__CLASS__.'/edit'),
                    'urlEdit' => site_url(__CLASS__.'/edit/'),
                    'editable' => true,
                    'friendyUrlEdit' => true,
                    'list' => $products,
                    'title' => 'Produtos',
                    DataTable::OPTION_paginate => true,
                    DataTable::OPTION_currentPage => $currentPage,
                    DataTable::OPTION_amountRegisters => $amout,
                    DataTable::OPTION_amountPerPage => self::$NUMREGISTERS_PER_PAGE,
                    DataTable::OPTION_targetUrl => site_url(__CLASS__ . '/search?search='.$params['search'].'&p=')
                ));
        $a['data'] = &$dat;
        $dat->addDisplayField('Código', 'id', DataTable::STRING, NULL, '5%');
        $dat->addDisplayField('Nome', 'name', DataTable::STRING, NULL, '80%');
        $dat->addDisplayField('Valor Venda', 'sellValue', DataTable::CURRENCY, NULL, '5%');
        $this->adminView('products_results.php', $a);
    }

    public function edit() {
        $this->addWay(__CLASS__.'/edit', 'edição');
        if ($this->uri->segment(3) != '') {
            $product = $this->service->getById($this->uri->segment(3));
        } else {
            $product = new Product();
        }

        $arr = array();

        $arr['product'] = &$product;
        $this->adminView('products_edit.php', $arr);
    }

    public function save() {
        $this->addWay(__CLASS__.'/save', 'salvar');
        $id = $_POST['id'];
        $name = $_POST['name'];
        $decription = $_POST['description'];
        $sellValue = $_POST['sellValue'];
        
        if ($id != '') {
            $prod = $this->service->getById($id);
        } else {
            $prod = new Product();
        }

        $prod->setName($name);
        $prod->setDescription($decription);
        $prod->setSellValue(StringUtil::toFloat($sellValue));

        $arr = array();
        $arr['product'] = &$prod;
        try {
            if ($id == '') {
                $this->service->save($prod);
            } else {
                $this->service->update($prod);
            }
            redirect(__CLASS__.'/search?search=' . urlencode($prod->getId()), 'location', 301);
        } catch (ValidationException $v) {

            $error = array();

            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $arr['error'] = &$error;
            $this->adminView('products_edit.php', $arr);
        }
    }

}

?>
