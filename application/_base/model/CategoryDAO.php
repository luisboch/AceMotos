<?php

import('Category.php');
import('model/BasicDAO.php');

/**
 * Description of CategoryDAO
 *
 * @author luis
 * @since Jul 25, 2012
 */
class CategoryDAO extends BasicDAO {

    function __construct() {
        $this->setTableName("categorias");
    }

    /**
     * @param Category $entity
     */
    protected function executeDelete(Entity &$entity) {
        $sql = "delete from " . $this->getTableName() . " where id = ?";
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
    }

    /**
     *
     * @param Category $entity
     */
    protected function executeInsert(Entity &$entity) {
        $sql = "
            insert into " . $this->getTableName() . " (`descricao`, `categoria_id`)
            values (?, ?)";
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getCategory() == null ? null : $entity->getCategory()->getId(), PreparedStatement::INTEGER);
        $p->execute();
        $entity->setId($this->getConn()->lastId());
    }

    /**
     *
     * @param Category $entity
     */
    protected function executeUpdate(Entity &$entity) {

        $sql = "
            update " . $this->getTableName() . ' 
               set descricao = ?, categoria_id = ? ' .
                'where id = ?';

        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getCategory() == null ? null : $entity->getCategory()->getId(), PreparedStatement::INTEGER);
        $p->setParameter(3, $entity->getId(), PreparedStatement::INTEGER);

        $p->execute();
    }

    /**
     *
     * @return string
     */
    public function getFields() {
        return '`id`, `descricao`, `categoria_id`';
    }

    /**
     *
     * @param ResultSet $rs
     * @return
      /**
     *
     * @param Category $entity
     */
    public function getObject(ResultSet &$rs) {
        return $this->getObjectByOption($rs);
    }

    /**
     *
     * @param ResultSet $rs
     * @param boolean $forceLoadParent
     * @return Category
     */
    public function getObjectByOption(ResultSet &$rs, $forceLoadParent = true) {
        $arr = $rs->fetchArray();
        $c = new Category();
        $c->setId($arr['id']);
        $c->setDescription($arr['descricao']);
        if ($forceLoadParent && $arr['categoria_id'] != '') {
            $c->setCategory($this->getById($arr['categoria_id']));
        }
        return $c;
    }

    /**
     *
     * @param string $string
     * @return List<Category>
     */
    public function search($string) {
        $sql = "
            select c.descricao, c.id, c.categoria_id, cb.id as parent_id, cb.descricao as parent_description
              from " . $this->getTableName() . ' c
         left join ' . $this->getTableName() . ' cb on(cb.id = c.categoria_id)
             where c.id = ? 
                or c.descricao like ? 
                or c.categoria_id = ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);
        $p->setParameter(3, '%' . $string . '%', PreparedStatement::INTEGER);

        $rs = $p->execute();

        $objs = array();

        while ($rs->next()) {
            $arr = $rs->fetchArray();
            $c = new Category();
            $c->setId($arr['id']);
            $c->setDescription($arr['descricao']);
            if ($arr['parent_id'] != '') {
                $cat = new Category();
                $cat->setId($arr['parent_id']);
                $cat->setDescription($arr['parent_description']);
                $c->setCategory($cat);
            }

            $objs[] = $c;
        }
        return $objs;
    }

    /**
     * @param Category $parent
     * @return List<Category>
     */
    public function searchByParent(Category $parent = null) {
        $sql = "
            select " . $this->getFields() . "
              from " . $this->getTableName() . '
             where categoria_id  ' . ($parent == null ? ' is null' : ' = ?') . '';
        $p = $this->getConnection()->prepare($sql);
        if ($parent != null) {
            $p->setParameter(1, $parent->getId(), PreparedStatement::INTEGER);
        }
        $rs = $p->execute();

        $objs = array();

        while ($rs->next()) {
            $ob = $this->getObjectByOption($rs, false);
            if ($parent != null) {
                $ob->setCategory($parent);
            }
            $objs[] = $ob;
        }

        return $objs;
    }

    /**
     * @param Category $parent
     * @return List<Category>
     */
    public function getRootCategories() {
        
        $list = $this->search("%");

        $roots = array();
        $rootIds = array();
        foreach ($list as $ob) {
            if (!$ob->isRoot()) {
                $i = array_search($ob->getCategory()->getId(), $rootIds);
                $root = null;
                
                if($i !== false){
                    $root = $roots[$i];
                } else {
                    $root = $ob->getCategory();
                    $roots[] = $root;
                    $rootIds[] = $ob->getCategory()->getId();
                }
                
                $childs = $root->getChildren();
                
                $found = false;
                foreach($childs as $k => $v){
                    if($v->getId() == $ob->getId()){
                        $found = true;
                        break;
                    }
                }
                
                if(!$found){
                    $childs[] = $ob;
                }
                $root->setChildren($childs);
                $roots[$i] = $root;
                
            }
        }

        return $roots;
    }

}

?>
