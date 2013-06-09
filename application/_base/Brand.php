<?php

import('interfaces/Entity.php');
import('interfaces/ILogicalDeletion.php');

/**
 * @author luis
 */

class Brand implements Entity, ILogicalDeletion{
    
    private $id;
    private $name;
    private $status = true;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

?>
