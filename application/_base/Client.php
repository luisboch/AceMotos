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
class Client implements Entity {

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
     * @var boolean
     */
    private $validated;

    /**
     *
     * @var boolean 
     */
    private $active;

    /**
     *
     * @var string 
     */
    private $countryCode;

    /**
     *
     * @var string
     */
    private $timeZone;

    /**
     *
     * @var string
     */
    private $type;

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

    /**
     * 
     * @return boolean
     */
    public function getRegistered() {
        return $this->registered;
    }

    /**
     * 
     * @param boolean $registered
     */
    public function setRegistered($registered) {
        $this->registered = $registered;
    }

    /**
     * 
     * @return boolean
     */
    public function getValidated() {
        return $this->validated;
    }

    /**
     * 
     * @param boolean $validated
     */
    public function setValidated($validated) {
        $this->validated = $validated;
    }

    /**
     * 
     * @return string
     */
    public function getCountryCode() {
        return $this->countryCode;
    }

    /**
     * 
     * @param string $countryCode
     */
    public function setCountryCode($countryCode) {
        $this->countryCode = $countryCode;
    }

    /**
     * 
     * @return string
     */
    public function getTimeZone() {
        return $this->timeZone;
    }

    /**
     * 
     * @param string $timeZone
     */
    public function setTimeZone($timeZone) {
        $this->timeZone = $timeZone;
    }

    /**
     * 
     * @return string F if is Fisical, J when Juridic
     */
    public function getType() {
        return $this->type;
    }

    /**
     * 
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * 
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * 
     * @param booelan $active
     */
    public function setActive($active) {
        $this->active = $active;
    }

}

?>
