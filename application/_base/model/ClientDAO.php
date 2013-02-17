<?php
import('Client.php');
import('model/BasicDAO.php');
/**
 * Description of ClientDAO
 *
 * @author Luis
 */
class ClientDAO extends BasicDAO {

    function __construct() {
        $this->setTableName('clients');
    }

    protected function executeInsert(Entity &$entity) {
        $sql = "
            insert 
              into `clients`(
                   `name`, `email`, `receive_news`, `registered`, `validated`, 
                   `timezone`, `country_code`, `type`)
            values (?,?,?,?,?,?,?,?)";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getEmail(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->receiveNews(), PreparedStatement::BOOLEAN);
        $p->setParameter(4, $entity->getRegistered(), PreparedStatement::BOOLEAN);
        $p->setParameter(5, $entity->getValidated(), PreparedStatement::BOOLEAN);
        $p->setParameter(6, $entity->getTimeZone(), PreparedStatement::STRING);
        $p->setParameter(7, $entity->getCountryCode(), PreparedStatement::STRING);
        $p->setParameter(8, $entity->getType(), PreparedStatement::STRING);
        $p->execute();
        
        $entity->setId($this->getConn()->lastId());
        
    }

    protected function executeUpdate(Entity &$entity) {
        $sql = "
            UPDATE `clients` 
                SET `name`=?,
                    `email`=?,
                    `receive_news`=?,
                    `registered`=?,
                    `validated`=?,
                    `timezone`=?,
                    `country_code`=?,
                    `type`=? 
                    `active`=? 
               WHERE id = ?";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getEmail(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->receiveNews(), PreparedStatement::BOOLEAN);
        $p->setParameter(4, $entity->getRegistered(), PreparedStatement::BOOLEAN);
        $p->setParameter(5, $entity->getValidated(), PreparedStatement::BOOLEAN);
        $p->setParameter(6, $entity->getTimeZone(), PreparedStatement::STRING);
        $p->setParameter(7, $entity->getCountryCode(), PreparedStatement::STRING);
        $p->setParameter(8, $entity->getType(), PreparedStatement::STRING);
        $p->setParameter(9, $entity->getActive(), PreparedStatement::BOOLEAN);
    }
    /**
     * 
     * @return string
     */
    public function getFields() {
        return ' `id`, `name`, `email`, `receive_news`, `register_date`, 
            `registered`, `validated`, `timezone`, `country_code`, `type`  ';
    }

    public function getObject(ResultSet &$rs) {
        $c = new Client();
        $arr = $rs->fetchArray();
        $c->setName($arr['name']);
        $c->setId($arr['id']);
        $c->setEmail($arr['email']);
        $c->setReceiveNews($arr['receive_news']);
        $c->setRegisterDate($arr['register_date']);
        $c->setRegistered($arr['registered']);
        $c->setValidated($arr['validated']);
        $c->setTimeZone($arr['timezone']);
        $c->setCountryCode($arr['country_code']);
        $c->setType($arr['type']);
        return $c;
    }

    public function search($string) {
        
    }
}

?>
