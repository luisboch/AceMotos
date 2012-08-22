<?php

/**
 *
 * @author felipe
 * @since Jul 22, 2012
 */
class Notices extends LC_Controller {

    function __construct() {
        parent::__construct();
        import("util/components/DataTable.php");
        import('services/NoticeService.php');
        $this->service = new NoticeService();
        $this->addWay(__CLASS__, 'noticias');
    }

    public function index() {
        $this->addWay(__CLASS__ . '/index', 'home');
        $this->adminView('notices_index.php');
    }

    public function search() {
        $this->addWay('Notices/search', 'pesquisa');

        $params = $this->getRequestParams(array('search' => '%', 'p' => 1));

        $currentPage = $params['p'];

        $start = Pagination::getOffset($currentPage, self::$NUMREGISTERS_PER_PAGE);

        $amout = $this->service->count(urldecode($params['search']));

        $notices = $this->service->search(urldecode($params['search']), $start, self::$NUMREGISTERS_PER_PAGE);
        $dat = new DataTable(array(
                    'btSearch' => true,
                    'urlSearch' => site_url('Notices'),
                    'btCreate' => true,
                    'urlCreate' => site_url('Notices/edit'),
                    'urlEdit' => site_url('Notices/edit/'),
                    'editable' => true,
                    'friendyUrlEdit' => true,
                    'list' => $notices,
                    'title' => 'Noticias',
                    DataTable::OPTION_paginate => true,
                    DataTable::OPTION_currentPage => $currentPage,
                    DataTable::OPTION_amountRegisters => $amout,
                    DataTable::OPTION_amountPerPage => self::$NUMREGISTERS_PER_PAGE,
                    DataTable::OPTION_targetUrl => site_url(__CLASS__ . '/search?search='.$params['search'].'&p=')
                ));
        $a['data'] = &$dat;
        $dat->addDisplayField('Código', 'id', DataTable::STRING, NULL, '5%');
        $dat->addDisplayField('Titulo', 'title', DataTable::STRING, NULL, '82%');
        $dat->addDisplayField('Imagem', 'linkedImage(webImage, \\' . site_url('Notices/images/') . '\, id, true)', DataTable::FN, NULL, '8%');
        $this->adminView('notices_results.php', $a);
    }

    public function edit() {
        $this->addWay('Notices/edit', 'edição');
        if ($this->uri->segment(3) != '') {
            $notice = $this->service->getById($this->uri->segment(3));
        } else {
            $notice = new Notice();
        }

        $arr = array();

        $arr['notice'] = &$notice;
        $this->adminView('notices_edit.php', $arr);
    }

    public function save() {
        $this->addWay('Notices/save', 'salvar');
        $id = $_POST['id'];
        $title = $_POST['title'];
        $resume = $_POST['resume'];
        $notice = $_POST['notice'];

        $not = $this->service->getById($id);

        $not->setId($id);
        $not->setTitle($title);
        $not->setResume($resume);
        $not->setNotice($notice);

        $this->load->helper('select');
        $this->load->helper('inputpass');

        $arr = array();
        $arr['notice'] = &$not;
        try {
            if ($id == '') {
                $this->service->save($not);
            } else {
                $this->service->update($not);
            }
            redirect('/Notices/search?search=' . urlencode($not->getTitle()), 'location', 301);
        } catch (ValidationException $v) {

            $error = array();

            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $arr['error'] = &$error;
            $this->adminView('notices_edit.php', $arr);
        }
    }

    public function upload() {
        if ($_POST['id'] != '') {
            $this->load->helper('simpleupload');
            $this->load->helper('adminimage');
            import('lib/image/ImageUpload.php');
            $this->addWay(site_url(__CLASS__ . '/upload'), 'upload');

            $img = new ImageUpload('notices');

            $arr['notice'] = $this->service->getById($_POST['id']);

            try {

                $arr['webImage'] = $img->upload('notices');
                $arr['librarie'] = 'notices';
                $arr['targetupload'] = site_url(__CLASS__ . '/upload');
                $arr['targetsave'] = site_url('Notices/saveUpload/' . $arr['notice']->getId());
                $this->adminView('single_image_upload.php', $arr);
            } catch (Exception $exeption) {
                $arr['error'] = $exeption->getMessage();
                $arr['librarie'] = 'notices';
                $arr['targetupload'] = site_url(__CLASS__ . '/upload');
                $arr['targetsave'] = site_url('Notices/saveUpload/' . $arr['notice']->getId());
                $this->adminView('single_image_upload.php', $arr);
            }
        } else {
            $this->index();
        }
    }

    public function images() {
        $this->load->helper('simpleupload');
        $this->load->helper('adminimage');
        $this->addWay('Notices/images', 'imagens');

        $arr['notice'] = $this->service->getById($this->uri->segment(3));
        $arr['librarie'] = 'notices';
        $arr['targetupload'] = site_url('Notices/upload');
        $arr['targetsave'] = site_url('Notices/saveUpload/' . $arr['notice']->getId());
        $this->adminView('single_image_upload.php', $arr);
    }

    public function saveUpload() {
        $this->load->helper('simpleupload');
        $this->load->helper('adminimage');

        $notice = $this->service->getById($this->uri->segment(3));
        if ($_POST['n_image'] != '') {
            $image = $_POST['n_image'];
            $webImage = new WebImage($image);
            $oldImage = $notice->getWebImage();
            $notice->setWebImage($webImage);

            try {
                $this->service->update($notice);
                if ($oldImage != null) {
                    $oldImage->delete();
                }
            } catch (Exception $e) {
                die('Erro ao salvar a imagem');
            }
        }
        $arr['librarie'] = 'notices';
        $arr['targetupload'] = site_url('Notices/upload');
        $arr['notice'] = &$notice;

        $arr['targetsave'] = site_url('Notices/saveUpload/' . $arr['notice']->getId());
        $this->adminView('single_image_upload.php', $arr);
    }

}

?>
