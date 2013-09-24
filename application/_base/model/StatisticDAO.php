<?php

import("Statistic.php");
import("model/BasicDAO.php");

/**
 * Description of StatisticDAO
 *
 * @author Luis
 */
class StatisticDAO extends BasicDAO{
    
    //put your code here

    function __construct() {
        $this->setTableName(" `estatisticas` ");
    }
    
    protected function executeInsert(Entity &$entity) {
        /* @var $entity Statistic */
        $sql = "insert into " . $this->getTableName() . " (pagina, item_id, observacao) values (?,?,?)";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $entity->getPage(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getItem_id(), PreparedStatement::INTEGER);
        $p->setParameter(3, $entity->getObservation(), PreparedStatement::STRING);
        
        $p->execute();
        
        $entity->setId($this->getConn()->lastId());
        
    }

    protected function executeUpdate(Entity &$entity) {
        throw new Exception("Can't execute update");
    }

    public function getFields() {
        return '`id`, `pagina`, `data`, `item_id`, `observacao` ';
    }

    /**
     * @param ResultSet $rs
     * @return Statistic
     */
    public function getObject(ResultSet &$rs) {
        $arr = $rs->fetchArray();
        $st = new Statistic();
        $st->setId($arr['id']);
        $st->setDate($arr['data']);
        $st->setItem_id($arr['item_id']);
        $st->setObservation($arr['observacao']);
        $st->setPage($arr['page']);
        return $st;
    }

    public function search($string) {
        throw new Exception("Can't execute search");
    }    
}

?>
