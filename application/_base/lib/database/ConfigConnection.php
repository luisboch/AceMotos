<?php
/**
 * Description of ConfigConnection
 *
 * @author luis
 */
class ConfigConnection {

    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($production = TRUE) {
        if ($production === TRUE) {
            $this->host = "fdb2.runhosting.com";
            $this->password = "1105746_farm";
            $this->username = "1105746_farm";
            $this->database = "1105746_farm";
        } else {
            $this->host = "localhost";
            $this->password = "mysql";
            $this->username = "root";
            $this->database = "hardwarehouse";
        }
    }

    public function getHost() {
        return $this->host;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDatabase() {
        return $this->database;
    }

}

?>
