<?php
/**
 * Description of Connection
 *
 * @author luis
 */
class Connection {
    /**
     *
     * @var mysqli 
     */
    private static $conn = NULL;

    const PRODUCTION = 1;
    const DEVELOPMENT = 0;

    private static $type = 0;

    /**
     *
     * @var mysqli 
     */
    private $db_conn;

    private function __construct() {
        
    }

    /**
     * @return Connection
     */
    public static function &getConnection() {
        if (self::$conn === NULL) {
            self::$conn = self::makeConnection();
        }
        return self::$conn;
    }

    /**
     * @return Connection
     */
    private static function &makeConnection() {
        
        if(ENVIRONMENT == 'development'){
            self::forDevelopment();
        }
        else{
            self::forProduction();
        }
        
        $config = new ConfigConnection(self::$type == 1 ? true : false);
        $c = new Connection();
        $c->db_conn = new mysqli($config->getHost(), $config->getUsername(),
                        $config->getPassword(), $config->getDatabase());
        if ($c->db_conn->connect_errno) {
            throw new DatabaseException("FALHA NA CONEXÃO COM O BANCO DE DADOS");
        }

        return $c;
    }

    /**
     *
     * @param string $string 
     * @return ResultSet 
     */
    public function query($sql) {
        $rs = new ResultSet($sql);
        $result = $this->db_conn->query($sql.';');
        if ($result === false) {
            throw new QueryException("ERRO AO PREPARAR QUERY " . $this->db_conn->error);
        }
        $rs->setMysqlResult($result);
        return $rs;
    }

    /**
     *
     * @param string $sql
     * @return PreparedStatement 
     */
    public function prepare($sql) {
        $stmt = $this->db_conn->prepare($sql.';');
        
        if ($stmt === false) {
            throw new QueryException("ERRO AO PREPARAR QUERY " . $this->db_conn->error);
        }
        return new PreparedStatement($stmt,$sql);
    }

    /**
     *
     * @param boolean $commit 
     */
    public function autoCommit($commit = true) {
        $this->db_conn->autocommit($commit);
    }

    public function commit() {
        $this->db_conn->commit();
        $this->db_conn->autocommit(true);
    }

    public function rollback() {
        $this->db_conn->rollback();
        $this->db_conn->autocommit(true);
    }

    public function begin() {
        $this->autoCommit(false);
    }

    public static function forProduction() {
        self::$type = self::PRODUCTION;
    }

    public static function forDevelopment() {
        self::$type = self::DEVELOPMENT;
    }

    public function lastId() {
        return $this->db_conn->insert_id;
    }
    
    public function close(){
        $this->db_conn->close();
    }
    
    public static function throwException($exption, $message){
        throw new $exption($message.self::$conn->error);
    }
}

?>
