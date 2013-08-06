<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
class ProductsController extends LC_Controller
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
        import('services/ProductService.php');
        import('services/CategoryService.php');
        $this->service = new ProductService();
        $this->addWay(__CLASS__, 'produtos');
        $this->categoryService = new CategoryService();
    }

    public function index()
    {
        $this->addWay(__CLASS__ . '/index', 'home');
        $this->adminView('products_index.php');
    }

    public function search()
    {
        $this->addWay(__CLASS__ . '/search', 'pesquisa');

        $params = $this->getRequestParams(array('search' => '%', 'p' => 1));

        $currentPage = $params['p'];

        $start = Pagination::getOffset($currentPage, self::$NUMREGISTERS_PER_PAGE);

        $amout = $this->service->count(urldecode($params['search']));

        $products = $this->service->search(urldecode($params['search']), $start, self::$NUMREGISTERS_PER_PAGE);

        $dat = new DataTable(array(
            'btSearch' => false,
            'urlSearch' => site_url(__CLASS__),
            'btCreate' => false,
            'urlCreate' => site_url(__CLASS__ . '/edit'),
            'urlEdit' => site_url(__CLASS__ . '/edit/'),
            'editable' => true,
            'friendlyUrlEdit' => false,
            'list' => $products,
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
        $dat->addDisplayField('Valor Venda', 'sellValue', DataTable::CURRENCY, NULL, '10%');
        $dat->addDisplayField('Imagem', 'linkedFirstImage(images,\\' . site_url(__CLASS__ . '/images/') . '\, id, true)', DataTable::FN);
        $this->adminView('products_results.php', $a);
    }

    public function edit()
    {
        $this->load->helper('select');
        $this->load->helper('textarea');
        $categories = $this->categoryService->search();
        $this->addWay(__CLASS__ . '/edit', 'edição');
        if ($_GET['id'] != '') {
            $product = $this->service->getById($_GET['id']);
        } else {
            $product = new Product();
        }

        $arr = array();

        $arr['product'] = & $product;
        $arr['categories'] = & $categories;
        $this->adminView('products_edit.php', $arr);
    }

    public function save()
    {
        $this->addWay(__CLASS__ . '/save', 'salvar');
        $id = $_POST['id'];
        $name = $_POST['name'];
        $showIndex = $_POST['showIndex'];

        $decription = $_POST['description'];
        $sellValue = $_POST['sellValue'];
        $categoryId = $_POST['category'];


        if ($id != '') {
            $prod = $this->service->getById($id);
        } else {
            $prod = new Product();
        }
        if ($categoryId != '') {
            $prod->setCategory($this->categoryService->getById($categoryId));
        } else {
            $prod->setCategory(NULL);
        }
        $prod->setName($name);
        $prod->setDescription($decription);
        $prod->setSellValue(StringUtil::toFloat($sellValue));
        $prod->setShowIndex($showIndex == 'on' ? 1 : 0);

        $arr = array();
        $arr['product'] = & $prod;
        try {
            if ($id == '') {
                $this->service->save($prod);
            } else {
                $this->service->update($prod);
            }
            redirect(__CLASS__ . '/search?search=' . urlencode($prod->getId()), 'location', 301);
        } catch (ValidationException $v) {

            $this->load->helper('select');
            $this->load->helper('textarea');
            $categories = $this->categoryService->search();
            $error = array();

            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $arr['error'] = & $error;
            $arr['categories'] = & $categories;

            $this->adminView('products_edit.php', $arr);
        }
    }

    public function images($product = NULL)
    {
        $this->load->helper('multipleupload');
        $this->load->helper('adminimage');
        $this->addWay(__CLASS__ . '/images', 'imagens');

        $arr['product'] = $product === NULL || !is_object($product) ?
            $this->service->getById($this->uri->segment(3)) : $product;
        $arr['librarie'] = 'products';
        $arr['targetupload'] = site_url(__CLASS__ . '/upload');
        $arr['targetremove'] = site_url(__CLASS__ . '/remove');
        $arr['targetback'] = site_url(__CLASS__ . '/search?search=' .
            $arr['product']->getId());
        $arr['targetedit'] = site_url(__CLASS__ . '/edit/' .
            $arr['product']->getId());

        $arr['targetsave'] = site_url(__CLASS__ . '/saveUpload/' .
            $arr['product']->getId());
        $this->adminView('multiple_image_upload.php', $arr);
    }

    public function saveUpload()
    {

        import('lib/image/ImageUpload.php');
        if ($_POST['id'] != '') {
            import('lib/image/ImageUpload.php');

            $img = new ImageUpload('products');

            $product = $this->service->getById($_POST['id']);

            try {
                $imgs = $img->upload('product');
                $this->service->saveImages($product, $imgs);

                $this->images($product);
            } catch (Exception $exeption) {
                $arr['product'] = $product;
                $arr['error'] = $exeption->getMessage();
                $arr['librarie'] = 'product';
                $arr['targetupload'] = site_url(__CLASS__ . '/upload');
                $arr['targetremove'] = site_url(__CLASS__ . '/remove');

                $arr['targetsave'] = site_url(__CLASS__ . '/saveUpload/' . $arr['product']->getId());
                $this->load->helper('multipleupload');
                $this->load->helper('adminimage');
                $this->adminView('multiple_image_upload.php', $arr);
            }
        } else {
            $this->index();
        }
    }

    public function remove()
    {
        if ($_GET['i'] == '' || !is_numeric($_GET['i'])) {
            $this->images();
        } else {
            $productId = $this->uri->segment(3);
            if ($productId == '' || !is_numeric($productId)) {
                $this->index();
            } else {
                $product = $this->service->getById($productId);
                $this->service->removeImage($product, $_GET['i']);
                $this->images($product);
            }
        }
    }

}

?>
