<?php

/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 14, 2012
 */
interface EntityDAO {
    function getById($id);
    function save(Entity &$entity, $autocommit = true);
    function update(Entity &$entity, $autocommit = true);
    function delete(Entity &$entity, $autocommit = true);
    function search($string);
    /**
     * @return string 
     */
    function getFields();
    /**
     * @return Entity
     */
    function getObject(ResultSet &$rs);
    
    function paginationSearch($string, $start = NULL, $limit=NULL);
    
    function count($string);
}

?>
