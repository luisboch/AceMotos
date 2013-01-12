<?php
/**
 * Description of ConfigConnection
 *
 * @author luis
 */
class ConfigConnection
{

    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($production = TRUE)
    {
        if ($production === TRUE) {
            $this->host = "localhost";
            $this->password = "mysql@x9m013e8mi0";
            $this->username = "root";
            $this->database = "hardwarehouse";
        } else {
            $this->host = "localhost";
            $this->password = "mysql";
            $this->username = "root";
            $this->database = "hardwarehouse";
        }
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDatabase()
    {
        return $this->database;
    }

}

?>
