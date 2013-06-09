<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
import('Brand.php');
import('model/BasicDAO.php');

class BrandDAO extends BasicDAO {

    //put your code here

    function __construct() {
        $this->setTableName(" `marcas` ");
    }
    
    protected function executeInsert(Entity &$entity) {
        /* @var $entity Brand */
        $sql = "insert into " . $this->getTableName() . " (nome) values (?)";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        
        $p->execute();
        
        $entity->setId($this->getConn()->lastId());
    }

    protected function executeUpdate(Entity &$entity) {

        /* @var $entity Brand */
        
        $sql = "UPDATE " . $this->getTableName() . " 
                    SET `nome`=?,
                        `status`=?
                    WHERE id=?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getStatus() === true?1:0, PreparedStatement::INTEGER);
        $p->setParameter(3, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
        
    }

    public function getFields() {
        return ' `id`, `nome`';
    }

    /**
     *
     * @param ResultSet $rs
     * @return Product
     */
    public function getObject(ResultSet &$rs) {
        $arr = $rs->fetchArray();

        $product = new Brand();
        $product->setId($arr['id']);
        $product->setName($arr['nome']);
        
        return $product;
    }

    public function search($string) {
        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where id = ? or nome like ? and status = 1';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $arr[] = & $this->getObject($rs);
        }

        return $arr;
    }

    public function count($string) {
        $sql = 'select count(*) as qtd from ' . $this->getTableName()
                . ' where ( id = ? or nome like ? ) and status = 1';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $rs->next();
        $arr = $rs->fetchAssoc();
        return $arr[0];
    }

    public function paginationSearch($string, $start = NULL, $limit = NULL) {

        if ($start === NULL || $limit === NULL) {
            return $this->search($string);
        }

        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where  ( id = ? or lower(nome) like lower(?) ) and status = 1 LIMIT ' . $start . ', ' . $limit;
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);
        
        $rs = $p->execute();
        
        $arr = array();

        while ($rs->next()) {
            $ob = & $this->getObject($rs);
            $arr[] = $ob;
        }
        
        return $arr;
    }
    
}
?>