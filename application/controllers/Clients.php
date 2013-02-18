<?php

/**
 * Description of ClientController
 *
 * @author Luis
 */
class Clients extends LC_Controller {

    private $timezones;

    function __construct() {
        parent::__construct();
        import('services/ClientService.php');
        import('util/TimeZoneUtil.php');

        $this->timezones = TimeZoneUtil::getAvaliableCities();
        $this->service = new ClientService();
    }

    protected function checkLogin() {
        return false;
    }

    public function register() {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $client = new Client();
        $client->setName($name);
        $client->setEmail($email);

        try {
            $this->service->saveNewsLetter($client);
            ?><script type="text/javascript">
                alert('Email cadastrado com sucesso!');
                window.history.go(-1);
            </script><?
            exit;
        } catch (ValidationException $e) {
            $alert = 'Ops, encontramos alguns problemas: \\n';

            foreach ($e->getErrors() as $v) {
                $alert .= $v->getMessage()." \\n";
            }
            ?><script type="text/javascript">
                alert('<?= $alert ?>');
                window.history.go(-1);
            </script><?
            exit;
        }
    }

}
?>
