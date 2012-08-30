<?php

/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 14, 2012
 */
interface IBasicService {
    function save(Entity &$entity);
    function update(Entity &$entity);
    function delete(Entity &$entity);
    function getById($id);
    function search($string = '%');
}
?>
