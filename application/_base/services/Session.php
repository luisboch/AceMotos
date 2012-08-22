<?php

/**
 *
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jun 23, 2012
 */

class Session {

    /**
     *
     * @var Session
     */
    private static $session = NULL;
    /**
     *
     * @var boolean
     */
    private static $_initialized = false;
    
    /**
     * @var User 
     */
    private $user;
    
    
    /**
     *
     * @var array 
     */
    private $cellPhoneResult= array();
    private function __construct() {//gera funcao construtora como private para bloquear outras instancias desta classe;
    }

    /**
     * @return Session
     */
    public function setUser(User &$user) {
        $this->user = &$user;
        return $this;
    }
    /**
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }
    /**
     *
     * @return Session 
     */
    public static function getSession() {

        self::initialize();

        return self::$session;
    }

    public static function initialize() {
        if (!self::$_initialized) {
            @session_start();


            if (self::$session === NULL && $_SESSION['s'] == '') {
                self::$session = new Session();
                $_SESSION['s'] = &self::$session;
            } else if ($_SESSION['s'] != '' && self::$session === NULL) {
                self::$session = &$_SESSION['s'];
            }

            self::$_initialized = true;
        }
    }

    public static function destroy() {
        self::initialize();
        self::$session = NULL;
        $_SESSION['s'] = NULL;
    }
    
    /**
     *
     * @param string $token
     * @return CellPhoneResult
     */
    public function getCellPhoneResult($token) {
        if($this->cellPhoneResult[base64_decode($token)] == ''){
            throw new NoResultException("No valid Value found in Session!");
        }
        return $this->cellPhoneResult[base64_decode($token)];
    }

    /**
     *  
     * @param CellPhoneResult $cellPhoneResult 
     * @return string
     */
    public function setCellPhoneResult(CellPhoneResult $cellPhoneResult) {
        
        $count = count($this->cellPhoneResult);
        
        $count++;
        
        $count = $count . self::$strToken;
        
        $this->cellPhoneResult[$count] = $cellPhoneResult;
        
        return base64_encode($count);
    }

    /**
     *
     * @var string
     */
    private static $strToken = '_tk';


}

?>
