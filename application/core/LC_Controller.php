<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LC_Controller extends CI_Controller {

    /**
     *
     * @var User
     */
    private $user;
    protected static $NUMREGISTERS_PER_PAGE = 20;

    /**
     *
     * @var BasicService 
     */
    protected $service;

    /**
     *
     * @var Logger
     */
    private $logger;
    private $ways = array('' => 'home');

    /**
     *
     * @var string
     */
    private $title = "Welcome to PHPFarm";
    private $url_home;

    function __construct() {
        parent::__construct();
        $this->setUrl_home(BASE_URL_HOME);

        // Loading basic classes
        import('interfaces/Entity.php');
        import('User.php');
        import('services/Session.php');

        //configure log
        Logger::configure(APPPATH . '_base/' . 'log4php.xml');

        //log support/
        $this->logger = Logger::getLogger(__CLASS__);
        import("lib/database.php");

        $session = Session::getSession();

        $this->user = $session->getUser();

        if ($this->checkLogin()) {
            $this->logger->info('Checking login...');
            if ($session->getUser() == NULL) {
                $this->logger->info('User not logged yet! redirecting to login page');
                $this->loginPage(FALSE, $_SERVER['REQUEST_URI']);
                exit;
            }
        }
    }

    public function index() {
        $this->adminView("index_page.php");
    }

    protected function adminView($view, $vars = array(), $return = FALSE) {
        // Set basic vars
        $arr['title'] = $this->title;
        $arr['url_home'] = $this->url_home;

        $arr['way'] = $this->getWays();

        $html = $this->load->view('header.php', $arr, true);
        $html .= $this->load->view('topbar.php', $arr, true);
        $html .= $this->load->view('menu.php', $arr, true);
        $html .= $this->load->view($view, $vars, true);
        $html .= $this->load->view('footer.php', $arr, true);

        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }

    public function getUrl_home() {
        return $this->url_home;
    }

    /**
     *
     * @param string $url_home 
     */
    protected function setUrl_home($url_home) {
        $this->url_home = $url_home;
    }

    public function getTitle() {
        return $this->title;
    }

    /**
     * You can use to espcific page title
     * @param type $title 
     */
    protected function setTitle($title) {
        $this->title = $title;
    }

    public function base() {

        // Set basic vars
        $arr['title'] = $this->title;
        $arr['url_home'] = $this->url_home;
        $this->adminView('base.php', $arr);
    }

    protected function checkLogin() {
        return true;
    }

    function encryptmd5() {
        echo md5($this->uri->segment(3));
    }

    /**
     *
     * @param array $default
     * @return array
     */
    protected function getRequestParams($default = array()) {
        if ($this->uri->segment(3) == '') {
            foreach ($default as $k => $v) {
                if ($_REQUEST[$k] != '') {
                    $default[$k] = $_REQUEST[$k];
                }
            }
            return $default;
        } else {
            $arr = &$this->uri->uri_to_assoc(3, $default);
            foreach ($default as $k => $v) {
                if ($arr[$k] == '') {
                    $arr[$k] = $v;
                }
            }
            return $arr;
        }
    }

    private function getWays() {
        $qtd = count($this->ways);
        if ($qtd == 1) {
            if ($this->uri->segment(3) != '' && $this->uri->segment(2) != '') {

                throw new InvalidArgumentException('Way must be defined!');
            }
        }
        $str = '';
        $i = 0;
        foreach ($this->ways as $k => $v) {
            if ($i + 1 == $qtd) {
                $str .= ($i != 0 ? ' > ' : '') . '<span class="nav-link">' .
                        $v . '</span>';
            } else {
                $str .= ($i != 0 ? ' > ' : '') . '<span class="nav-link"><a  href="' .
                        site_url($k) . '">' . $v . '</a></span>';
            }
            $i++;
        }
        return $str;
    }

    protected function addWay($way, $value) {
        $this->ways[$way] = $value;
    }

    public function loginPage($error = FALSE, $target = "") {
        $this->addWay("home", "LoginService");
        $this->load->helper('inputpass');
        // Set basic vars
        $arr['title'] = "Login";
        $arr['url_home'] = $this->getUrl_home();
        $arr['error'] = $error === TRUE;
        $arr['target'] = $target;
        $html = $this->load->view('header.php', $arr, true);
        $html .= $this->load->view('login.php', $arr, true);
        header('Content-Type: text/html; charset=utf-8');
        echo $html;
    }

    protected function loadJson($arr) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($arr, true);
    }

    protected function loadXml($arr) {
        header('Content-Type: text/xml; charset=utf-8');
        echo $this->xml_encode($arr);
    }

    protected function xml_encode($mixed, $domElement = null, $DOMDocument = null) {
        if (is_null($DOMDocument)) {
            $DOMDocument = new DOMDocument;
            $DOMDocument->formatOutput = true;
            $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
            echo $DOMDocument->saveXML();
        } else {
            if (is_array($mixed)) {
                foreach ($mixed as $index => $mixedElement) {
                    if (is_int($index)) {
                        if ($index == 0) {
                            $node = $domElement;
                        } else {
                            $node = $DOMDocument->createElement($domElement->tagName);
                            $domElement->parentNode->appendChild($node);
                        }
                    } else {
                        $plural = $DOMDocument->createElement($index);
                        $domElement->appendChild($plural);
                        $node = $plural;
                        if (rtrim($index, 's') !== $index) {
                            $singular = $DOMDocument->createElement(rtrim($index, 's'));
                            $plural->appendChild($singular);
                            $node = $singular;
                        }
                    }
                    $this->xml_encode($mixedElement, $node, $DOMDocument);
                }
            } else {
                $domElement->appendChild($DOMDocument->createTextNode($mixed));
            }
        }
    }

    public function delete() {
        $ids = $_POST['ids'];
        foreach ($ids as $id) {
            $ob = $this->service->getById($id);
            $class = get_class($ob);
            $this->logger->info('User [' . $this->user->getName() . ':' .
                    $this->user->getId() . '] deleting instance of [' . $class .
                    '] with id: ' . $id);
            $this->service->delete($ob);
        }
        $this->search();
    }

    public function search() {
        show_404();
    }

}

?>