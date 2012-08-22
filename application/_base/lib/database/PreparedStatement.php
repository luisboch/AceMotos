<?php
/**
 *  PreparedStatement
 *
 * @author luis
 */
class PreparedStatement {
    const STRING = "s";
    const DOUBLE = "d";
    const INTEGER = "i";
    const BLOB = "b";
    const BOOLEAN = "i";
    /**
     *
     * @var string 
     */
    private $sql;
    /**
     * have the type of parameters
     * @var array 
     */
    protected $types = array();

    /**
     * have the parameters for prepared statement
     * @var array 
     */
    protected $parameters = array();

    /**
     *
     * @var mysqli_stmt 
     */
    protected $statement;

    /**
     *
     * @param  mysqli_stmt $stmt 
     * @param string $sql
     */
    public function __construct(mysqli_stmt $stmt,$sql) {
        $this->statement = $stmt;
        $this->sql = $sql;
    }

    /**
     *
     * @param integer $index
     * @param object $parameter 
     * @param string $type
     */
    public function setParameter($index, $parameter, $type) {
        $this->parameters[$index] = $parameter;
        $this->types[$index] = $type;
    }

    /**
     *
     * @return ResultSet 
     */
    public function execute() {
        $parameters = "";
        $types = "";
        $size = count($this->parameters);
        //percorre os parametros
        $log = "BINDING PARAMS:";
        foreach ($this->parameters as $k => $v) {
            $parameters .= '$var_' . $k;
            if ($size > $k) {
                $parameters .=", ";
            }
            $types .= $this->types[$k];
            eval('$var_' . $k . ' = $v;');
            $log .= "[".$k."]=>".$v."\t";
        }
//        Console::log($log);
        $eval = '$this->statement->bind_param(\'' . $types . '\',' . $parameters . ');';
        if(count($this->parameters) > 0){
            eval($eval);
        }
        $result = $this->statement->execute();
        if($result=== FALSE){
            throw new QueryException( "ERRO AO PREPARAR QUERY ".$this->statement->error);
        }
        $rs = new ResultSet($this->sql);
        $rs->setMysqlStmt($this->statement);
        return $rs;
    }
}

?>
