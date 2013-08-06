<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
class BrandsController extends LC_Controller
{

    /**
     * @var CategoryService
     */
    protected $categoryService;

    function __construct()
    {
        parent::__construct();
        import("util/components/DataTable.php");
        import("util/StringUtil.php");
        import('services/BrandService.php');
        $this->service = new BrandService();
        $this->addWay(__CLASS__, 'marcas');
    }

    public function index()
    {
        $this->addWay(__CLASS__ . '/index', 'home');
        $this->adminView('brands_index.php');
    }

    public function search()
    {
        $this->addWay(__CLASS__ . '/search', 'pesquisa');

        $params = $this->getRequestParams(array('search' => '%', 'p' => 1));

        $currentPage = $params['p'];

        $start = Pagination::getOffset($currentPage, self::$NUMREGISTERS_PER_PAGE);

        $amout = $this->service->count(urldecode($params['search']));

        $brands = $this->service->search(urldecode($params['search']), $start, self::$NUMREGISTERS_PER_PAGE);

        $dat = new DataTable(array(
            'btSearch' => false,
            'urlSearch' => site_url(__CLASS__),
            'btCreate' => false,
            'urlCreate' => site_url(__CLASS__ . '/edit'),
            'urlEdit' => site_url(__CLASS__ . '/edit/'),
            'editable' => true,
            'friendlyUrlEdit' => false,
            'list' => $brands,
            'title' => 'Produtos',
            'canDelete' => true,
            'urlDelete' => site_url(__CLASS__ . '/delete'),
            DataTable::OPTION_paginate => true,
            DataTable::OPTION_currentPage => $currentPage,
            DataTable::OPTION_amountRegisters => $amout,
            DataTable::OPTION_amountPerPage => self::$NUMREGISTERS_PER_PAGE,
            DataTable::OPTION_targetUrl => site_url(__CLASS__ . '/search?search=' . $params['search'] . '&p=')
        ));
        $a['data'] = & $dat;
        $dat->addDisplayField('Código', 'id', DataTable::STRING, NULL, '10%');
        $dat->addDisplayField('Nome', 'name', DataTable::STRING, NULL, '60%');
        $this->adminView('brands_results.php', $a);
    }

    public function edit()
    {
        
        $this->addWay(__CLASS__ . '/edit', 'edição');
        
        if ($_GET['id'] != '') {
            $brand = $this->service->getById($_GET['id']);
        } else {
            $brand = new Brand();
        }

        $arr = array();

        $arr['brand'] = & $brand;
        $this->adminView('brands_edit.php', $arr);
    }

    public function save()
    {
        $this->addWay(__CLASS__ . '/save', 'salvar');
        $id = $_POST['id'];
        $name = $_POST['name'];


        if ($id != '') {
            $brand = $this->service->getById($id);
        } else {
            $brand = new Brand();
        }
        
        $brand->setName($name);

        $arr = array();
        
        $arr['brand'] = & $brand;
        try {
            if ($id == '') {
                $this->service->save($brand);
            } else {
                $this->service->update($brand);
            }
            
            redirect(__CLASS__ . '/search?search=' . urlencode($brand->getId()), 'location', 301);
        } catch (ValidationException $v) {
            $categories = $this->categoryService->search();
            $error = array();
            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $arr['error'] = & $error;

            $this->adminView('brands_edit.php', $arr);
        }
    }
}

?>
