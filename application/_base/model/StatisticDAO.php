<?php

import("Statistic.php");
import("model/BasicDAO.php");
import("model/ProductDAO.php");
import("model/CategoryDAO.php");
import('StatisticResult.php');

/**
 * Description of StatisticDAO
 *
 * @author Luis
 */
class StatisticDAO extends BasicDAO{
    
    /**
     *
     * @var ProductDAO
     */
    private $productDAO;
    
    /**
     *
     * @var CategoryDAO 
     */
    private $categoryDAO;
    
    //put your code here

    function __construct() {
        $this->setTableName(" `estatisticas` ");
        $this->productDAO = new ProductDAO();
        $this->categoryDAO = new CategoryDAO();
    }
    
    protected function executeInsert(Entity &$entity) {
        /* @var $entity Statistic */
        $sql = "insert into " . $this->getTableName() . " (pagina, item_id, observacao) values (?,?,?)";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $entity->getPage(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getItem_id(), PreparedStatement::INTEGER);
        $p->setParameter(3, $entity->getObservation(), PreparedStatement::STRING);
        
        $p->execute();
        
        $entity->setId($this->getConn()->lastId());
        
    }

    protected function executeUpdate(Entity &$entity) {
        throw new Exception("Can't execute update");
    }

    public function getFields() {
        return '`id`, `pagina`, `data`, `item_id`, `observacao` ';
    }

    /**
     * @param ResultSet $rs
     * @return Statistic
     */
    public function getObject(ResultSet &$rs) {
        $arr = $rs->fetchArray();
        $st = new Statistic();
        $st->setId($arr['id']);
        $st->setDate($arr['data']);
        $st->setItem_id($arr['item_id']);
        $st->setObservation($arr['observacao']);
        $st->setPage($arr['page']);
        return $st;
    }

    public function search($string) {
        throw new Exception("Can't execute search");
    }
    
    /**
     * @return StatisticResult
     */
    public function getStatistics() {
        
        $rs = new StatisticResult();
        
        $rs->setQtdLastWeek($this->getLastWeekQtd());
        $rs->setQtdThisWeek($this->getThisWeekQtd());
        $rs->setQtdYesterday($this->getYesterdayQtd());
        $rs->setQtdToday($this->getTodayQtd());
        $rs->setCatTen($this->getTopTenCategoryView());
        $rs->setPrdTen($this->getTopTenProductView());
        
        return $rs;
    }
    
    public function getLastWeekQtd() {
        
        $sql = "select count(id) as qtd from estatisticas where week(`data`)  = (week (now())-1)";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        $rs->next();
        
        $arr = $rs->fetchArray();
        
        return $arr['qtd'];
    }
    
    public function getThisWeekQtd() {
        
        $sql = "
            select count(id) as qtd 
              from estatisticas 
             where pagina = 'Products/view'
               and week(`data`)  = week(now())";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        $rs->next();
        
        $arr = $rs->fetchArray();
        
        return $arr['qtd'];
    }
    
    public function getYesterdayQtd() {
        
        $sql = "
            select count(id) as qtd
              from estatisticas 
             where pagina = 'Products/view'
               and day(`data`)  = (day(now())-1)";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        $rs->next();
        
        $arr = $rs->fetchArray();
        
        return $arr['qtd'];
    }
    
    public function getTodayQtd() {
        
        $sql = "
            select count(id) as qtd
              from estatisticas 
             where pagina = 'Products/view'
               and day(`data`)  = day(now())";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        $rs->next();
        
        $arr = $rs->fetchArray();
        
        return $arr['qtd'];
    }
    
    public function getTopTenProductView() {
        
        $sql = "
            select p.id, p.nome, count(e.id) as qtd
              from estatisticas e
              join produtos p on (e.item_id = p.id and e.pagina = 'Products/view')
             where MONTH(e.data) >= (MONTH(now())-2)
          group by p.id
          order by qtd desc
             limit 10";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        
        $prodcts = array();
        
        while($rs->next()){
            $arr = $rs->fetchArray();
            
            $prdt = new PrdtStatistc();
            $prdt->setProductId($arr['id']);
            $prdt->setProductName($arr['nome']);
            $prdt->setQtd($arr['qtd']);
            
            $prodcts[] = $prdt;
        }
        
        return $prodcts;
    }
    public function getTopTenCategoryView() {
        
        $sql = "
            select c.id, c.descricao, count(e.id) as qtd
              from estatisticas e
              join categorias c on (e.item_id = c.id and e.pagina = 'Products/viewCategory')
             where MONTH(e.data) >= (MONTH(now())-2)
          group by c.id
          order by qtd desc
             limit 10";
        
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        
        $categories = array();
        
        while($rs->next()){
            $arr = $rs->fetchArray();
            
            $cat = new CatStatistc();
            $cat->setCatId($arr['id']);
            $cat->setCatName($arr['descricao']);
            $cat->setQtd($arr['qtd']);
            
            $categories[] = $cat;
        }
        
        return $categories;
    }
}

?>
