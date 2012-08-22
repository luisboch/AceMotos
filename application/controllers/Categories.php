<?php

/**
 * Description of Categories
 *
 * @author luis
 * @since Jul 25, 2012
 */
class Categories extends LC_Controller {

    public function __construct() {
        parent::__construct();

        import("util/components/DataTable.php");
        import('services/CategoryService.php');
        $this->service = new CategoryService();
        $this->addWay(__CLASS__, "categorias");
    }

    public function index() {
        $this->addWay(__CLASS__ . '/index', 'home');
        $this->adminView("categories_index.php");
    }

    public function search() {
        $this->addWay(__CLASS__ . '/search', 'pesquisa');
        $params = $this->getRequestParams(array('search' => '%'));
        $notices = $this->service->search(urldecode($params['search']));


        $dat = new DataTable(array(
                    'btSearch' => true,
                    'urlSearch' => site_url(__CLASS__),
                    'btCreate' => true,
                    'urlCreate' => site_url(__CLASS__ . '/edit'),
                    'urlEdit' => site_url(__CLASS__ . '/edit/'),
                    'editable' => true,
                    'friendyUrlEdit' => true,
                    'list' => $notices,
                    'title' => 'Noticias'
                ));
        $a['data'] = &$dat;
        $dat->addDisplayField('Código', 'id', DataTable::STRING);
        $dat->addDisplayField('Descrição', 'description', DataTable::STRING);
        $dat->addDisplayField('Pai', 'category == null', DataTable::BOOLEAN);
        $dat->addDisplayField('Categoria Pai', 'category == null ? \\\ : category.description', DataTable::STRING);
        $this->adminView('notices_results.php', $a);
        
    }

    public function edit() {
        $this->addWay(__CLASS__ . '/edit', 'edição');
        if ($this->uri->segment(3) != '') {
            $cat = &$this->service->getById($this->uri->segment(3));
        } else {
            $cat = new Category();
        }
        $this->load->helper('select');
        $arr = array();

        $arr['cat'] = &$cat;
        $aux = &$this->service->getRootCategories();

        $categories = array();

        foreach ($aux as $ob) {
            if (!$ob->equals($cat)) {
                $categories[$ob->getId()] = $ob->getDescription();
            }
        }


        $arr['categories'] = &$categories;
        $this->adminView('categories_edit.php', $arr);
    }

    public function save() {
        $this->addWay(__CLASS__ . '/edit', 'salvar');
        $cat = new Category();
        $cat->setDescription($_POST['description']);
        $cat->setId($_POST['id']);

        if ($_POST['parent_id'] != '') {
            $parent = new Category();
            $parent->setId($_POST['parent_id']);
            $cat->setCategory($parent);
        }


        try {
            if ($_POST['id'] == '') {
                $this->service->save($cat);
            } else {
                $this->service->update($cat);
            }
            redirect('/' . __CLASS__ . '/search?search=' . urlencode($cat->getId()), 'location', 301);
        } catch (ValidationException $v) {

            $error = array();

            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $aux = &$this->service->getRootCategories();

            $categories = array();

            foreach ($aux as $ob) {
                if (!$ob->equals($cat)) {
                    $categories[$ob->getId()] = $ob->getDescription();
                }
            }

            $this->load->helper('select');

            $arr['categories'] = &$categories;
            $arr['error'] = &$error;
            $arr['cat'] = &$cat;
            $this->adminView('categories_edit.php', $arr);
        }
    }

}

?>
