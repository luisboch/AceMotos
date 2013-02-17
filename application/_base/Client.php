<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author Luis
 */
class Client implements Entity{
    /**
     *
     * @var int
     */
    private $id;
    /**
     *
     * @var string
     */
    private $name;
    /**
     *
     * @var string
     */
    private $email;
    /**
     *
     * @var boolean
     */
    private $receiveNews;
    /**
     *
     * @var DateTime
     */
    private $registerDate;
    
    /**
     *
     * @var boolean
     */
    private $registered;
    
    /**
     *
     * @var string 
     */
    private $rg;
    /**
     *
     * @var string
     */
    private $timeZone;
    /**
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    /**
     * 
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }
    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    /**
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }
    /**
     * 
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    /**
     * 
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }
    /**
     * 
     * @return boolean
     */
    public function getReceiveNews() {
        return $this->receiveNews;
    }
    /**
     * 
     * @return boolean
     */
    public function receiveNews() {
        return $this->receiveNews;
    }
    /**
     * 
     * @param boolean $receiveNews
     */
    public function setReceiveNews($receiveNews) {
        $this->receiveNews = $receiveNews;
    }
    /**
     * 
     * @return DateTime
     */
    public function getRegisterDate() {
        return $this->registerDate;
    }
    /**
     * 
     * @param DateTime $registerDate
     */
    public function setRegisterDate(DateTime $registerDate) {
        $this->registerDate = $registerDate;
    }
}

?>
