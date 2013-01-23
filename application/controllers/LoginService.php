<?php

/**
 *
 * @author luis
 */
class LoginService extends LC_Controller
{
    private $log;

    function __construct()
    {
        parent::__construct();
        $this->log = Logger::getLogger(__CLASS__);
        $this->addWay("LoginService", "LoginService");
    }

    public function index($error = FALSE)
    {
        $this->loginPage($error);
    }

    public function login()
    {

        $this->addWay("login", "LoginService/login");
        // Set basic vars
        import('services/UserService.php');
        import('services/Session.php');

        $arr['title'] = "Login";
        $arr['url_home'] = $this->getUrl_home();
        $service = new UserService();
        try {
            $user = $service->checkLogin($_POST['email'], $_POST['passwd']);
        } catch (NoResultException $er) {
            $this->log->info("User {email:" . $_POST['email'] . '} failed to login!');
            $this->loginPage(true, $_POST['target']);
            exit;
        }

        $this->log->info("User {name:" . $user->getName() . ' id: ' . $user->getId() . '} logged!');
        Session::getSession()->setUser($user);
        if ($_POST['target'] == '' && $_POST['target'] != 'LoginService/logout') {
            $target = site_url('Admin');
        } else {
            $target = $_POST['target'];
        }
        header('Location:' . $target);
        exit;
    }

    protected function checkLogin()
    {
        return false;
    }

    public function logout()
    {
        $this->addWay("login", "LoginService/login");
        import('services/Session.php');

        if (Session::getSession()->getUser() != '') {
            $this->log->info("User {name:" . Session::getSession()->getUser()->getName() . ' id: ' . Session::getSession()->getUser()->getId() . '} leaving application!');
        }
        Session::destroy();
        $this->index();
        exit;
    }

}

?>
