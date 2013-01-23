<?php

/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 15, 2012
 */
class _Users extends LC_Controller
{

    function __construct()
    {
        parent::__construct();
        import("util/components/DataTable.php");
        import('services/UserService.php');
        $this->service = new UserService();
        $this->addWay('_Users', 'usuarios');
    }

    public function index()
    {
        $this->addWay('_Users/index', 'home');
        $this->adminView('users_index.php');
    }

    public function search()
    {
        $this->addWay('_Users/search', 'pesquisa');
        $params = $this->getRequestParams(array('search' => '%'));
        $a['users'] = $this->service->search(urldecode($params['search']));
        $dat = new DataTable(array(
            'btSearch' => true,
            'urlSearch' => site_url('_Users'),
            'btCreate' => true,
            'urlCreate' => site_url('_Users/edit'),
            'urlEdit' => site_url('_Users/edit/'),
            'editable' => true,
            'friendlyUrlEdit' => true,
            'list' => $a['users'],
            'title' => 'Usuários'
        ));
        $a['data'] = & $dat;
        $dat->addDisplayField('Nome', 'name', DataTable::STRING);
        $dat->addDisplayField('Email', 'email', DataTable::STRING);
        $this->adminView('users_results.php', $a);
    }

    public function edit()
    {
        $this->addWay('_Users/edit', 'edição');
        if ($this->uri->segment(3) != '') {
            $user = $this->service->getById($this->uri->segment(3));
        } else {
            $user = new User();
        }
        $this->load->helper('select');
        $this->load->helper('inputpass');
        $arr = array();

        $arr['user'] = & $user;
        $this->adminView('users_edit.php', $arr);
    }

    public function save()
    {

        $this->addWay('_Users/save', 'salvar');
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $password = $_POST['password'];
        $group = $_POST['group'];

        $user = new User();

        $user->setId($id);
        $user->setPassword($password);
        $user->setName($name);
        $user->setEmail($email);
        $user->setPasswordConfirm($passwordConfirm);
        $user->setGroup($group);

        $this->load->helper('select');
        $this->load->helper('inputpass');
        $arr = array();
        $arr['user'] = & $user;
        try {
            if ($id == '') {
                $this->service->save($user);
            } else {
                $this->service->update($user);
            }
            redirect('/_Users/search?search=' . urlencode($user->getEmail()), 'location', 301);
        } catch (ValidationException $v) {

            $error = array();

            foreach ($v->getErrors() as $er) {
                $error[$er->getField()] = $er->getMessage();
            }

            $arr['error'] = & $error;
            $this->adminView('users_edit.php', $arr);

        }


    }
}

?>
