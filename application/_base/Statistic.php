<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Statistic
 *
 * @author Luis
 */
class Statistic implements Entity {
    private $id;
    private $page;
    private $date;
    private $item_id;
    private $observation;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getItem_id() {
        return $this->item_id;
    }

    public function setItem_id($item_id) {
        $this->item_id = $item_id;
    }

    public function getObservation() {
        return $this->observation;
    }

    public function setObservation($observation) {
        $this->observation = $observation;
    }
}

?>
