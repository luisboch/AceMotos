<?php
/**
 * @author luis
 */
class ResultSet {

    /**
     *
     * @var int
     */
    private $pointer;

    /**
     *
     * @var int
     */
    private $numRows;

    /**
     *
     * @var mixed
     */
    private $data;
    /**
     *
     * @var mixed 
     */
    private $map;
    /**
     *
     * @var array 
     */
    private $fields;

    function __construct($sql) {
        $this->pointer = -1;
        
        //pega a posição do select;
        $sql = strtolower($sql);
        $select = strpos($sql, "select");
        
        //se for um select
        if ($select !== false) {
            //tira a string "select"
            $sql = str_replace("select", "", $sql);
            
            //pega posição do from
            $pos = strpos($sql, "from");
            
            $remove = substr($sql, $pos);
            //remove do sql todo o from 
            $sql = str_replace($remove,'',$sql);
            
            //monta array baseado na virgula
            $fields = explode(',',$sql);
            
            foreach($fields as $v){
                $v = str_replace('`', '', $v);
                $pointer = strpos($v, '.');
                if($pointer!==false){
                    $v = substr($v, $pointer+1);
                }
                
                $as = strpos($v,' as ');
                
                if($as !== false){
                    $v = substr($v, $as+4);
                }
                
                $v = trim($v);
                
                $this->fields[]  = $v;
            }
        }
    }

    public function getNumRows() {
        return $this->numRows;
    }

    public function setNumRows($num_rows) {
        $this->numRows = $num_rows;
    }

    /**
     * @return boolean 
     */
    public function next() {
        $this->pointer++;
        $r =($this->pointer < $this->numRows);
        return $r ;
    }

    public function addData($data) {
        $this->data[] = $data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    /**
     *
     * @return array
     */
    public function fetchAssoc() {
        return $this->data[$this->pointer];
    }
    
    /**
     *
     * @return array
     */
    public function fetchArray() {
        return $this->map[$this->pointer];
    }

    public function setMysqlStmt(mysqli_stmt $stmt) {
        $parameters = "";
        $size = $stmt->field_count;
        $k = 0;
        if ($size > 0) {
            for ($i = 0; $i < $size; $i++) {
                $parameters .= '$var_' . $i;
                if ($size > $i + 1) {
                    $parameters .=", ";
                }
                eval('$var_' . $i . ' = NULL;');
            }
            eval('$stmt->bind_result(' . $parameters . ');');

            while ($stmt->fetch()) {
                $v = array();
                $map = array();
                
                for ($i = 0; $i < $size; $i++) {
                    eval('$v[$i] = $var_' . $i . ';');
                    eval('$map[$this->fields[$i]] = $var_' . $i . ';');
                }
                $this->data[] = $v;
                $this->map[] = $map;
                $k++;
            }
        }
        $this->setNumRows($k);
    }

    public function setMysqlResult(mysqli_result $result) {
        while ($v = $result->fetch_row()) {
            $this->data[] = $v;
            $map = array();
            foreach($v as $k => $v){
                $map[$this->fields[$k]] = $v; 
            }
            $this->map[]=$map;
        }
        $this->numRows = $result->num_rows;
    }

}

?>
