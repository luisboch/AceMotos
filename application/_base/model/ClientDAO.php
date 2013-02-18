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

        // Trata os valores default
        $news = $entity->receiveNews() == NULL ? true : $entity->receiveNews();
        $registerd = $entity->getRegistered() == NULL ? false : $entity->getRegistered();
        $validated = $entity->getValidated() == NULL ? false : $entity->getValidated();
        $timeZone = $entity->getTimeZone() == NULL ? 'America/Sao_Paulo' : $entity->getTimeZone();
        $countryCode = $entity->getCountryCode() == NULL ? '' : $entity->getCountryCode();
        $type = $entity->getType() == NULL ? 'F' : $entity->getType();
        
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getEmail(), PreparedStatement::STRING);
        $p->setParameter(3, $news, PreparedStatement::BOOLEAN);
        $p->setParameter(4, $registerd, PreparedStatement::BOOLEAN);
        $p->setParameter(5, $validated, PreparedStatement::BOOLEAN);
        $p->setParameter(6, $timeZone, PreparedStatement::STRING);
        $p->setParameter(7, $countryCode, PreparedStatement::STRING);
        $p->setParameter(8, $type, PreparedStatement::STRING);
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
        $c->setRegisterDate(new DateTime($arr['register_date']));
        $c->setRegistered($arr['registered']);
        $c->setValidated($arr['validated']);
        $c->setTimeZone($arr['timezone']);
        $c->setCountryCode($arr['country_code']);
        $c->setType($arr['type']);
        return $c;
    }

    /**
     * 
     * @param string $string
     * @return List<Client> list of clients found
     */
    public function search($string = "") {
        
        // gera o Sql
        $sql = "
            select " . $this->getFields() . ' 
              from ' . $this->getTableName() . "
             where active = true 
               and registered = true
               and validated = true
               and (lower(`name`) like lower(?) 
                or lower(`email`) like lower(?)
                or id = ?)";
        
        // Prepara a query
        $p = $this->getConn()->prepare($sql);
        
        // Seta os parametros
        $p->setParameter(1, "%".$string."%", PreparedStatement::STRING);
        $p->setParameter(2, "%".$string."%", PreparedStatement::STRING);
        $p->setParameter(3, "%".$string."%", PreparedStatement::INTEGER);
        
        // Pega o resultado
        $rs = $p->getResult();
        
        $list = array();
        
        // Monta a lista de objetos
        while ( $rs->next() ) {
            $ob = $this->getObject($rs);
            $list[] = $ob;
        }
        
        // Retorna a lista de resultados
        return $list;
    }

}

?>
