<?php
import('model/ClientDAO.php');
import('services/BasicService.php');
import('util/TimeZoneUtil.php');
/**
 * Description of ClientService
 *
 * @author Luis
 */
class ClientService extends BasicService{
    public function __construct() {
        parent::__construct(new ClientDAO());
    }
}

?>
