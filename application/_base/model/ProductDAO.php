<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
import('Product.php');
import('model/BasicDAO.php');

class ProductDAO extends BasicDAO {

    //put your code here

    function __construct() {
        $this->setTableName(" `produtos` ");
    }

    protected function executeDelete(Entity &$entity) {

        $sql = "delete from " . $this->getTableName() . " where id = ?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
    }

    protected function executeInsert(Entity &$entity) {

        $sql = "insert into " . $this->getTableName() . "(" . $this->getFields() . ") values (?,?,?,?)";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->setParameter(2, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getSellValue(), PreparedStatement::DOUBLE);
        $p->execute();
        $entity->setId($this->getConn()->lastId());
    }

    protected function executeUpdate(Entity &$entity) {

        $sql = "UPDATE " . $this->getTableName() . " 
                    SET `nome`=?,
                        `descricao`=?,
                        `valor_venda`=? 
                    WHERE id=?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getSellValue(), PreparedStatement::DOUBLE);
        $p->setParameter(4, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
        
        $this->saveImages($entity, false);
    }

    public function getFields() {
        return ' `id`, `nome`, `descricao`, `valor_venda` ';
    }

    /**
     *
     * @param ResultSet $rs
     * @return Product 
     */
    public function getObject(ResultSet &$rs) {
        $arr = $rs->fetchArray();

        $product = new Product();
        $product->setId($arr['id']);
        $product->setName($arr['nome']);
        $product->setDescription($arr['descricao']);
        $product->setSellValue($arr['valor_venda']);
        return $product;
    }

    public function search($string) {
        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where id = ? or nome like ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string, PreparedStatement::STRING);

        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $arr[] = &$this->getObject($rs);
        }

        return $arr;
    }

    public function count($string) {
        $sql = 'select count(*) as qtd from ' . $this->getTableName()
                . ' where id = ? or nome like ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $rs->next();
        $arr = $rs->fetchAssoc();
        return $arr[0];
    }

    public function paginationSearch($string, $start = NULL, $limit = NULL) {

        if ($start === NULL || $limit === NULL) {
            return $this->search($string);
        }

        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where id = ? or nome like ? LIMIT ' . $start . ', ' . $limit;
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string, PreparedStatement::STRING);
        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $ob = &$this->getObject($rs);
            $this->getImages($ob, 1, 0);
            $arr[] = $ob;
        }
        return $arr;
    }

    public function getImages(Product &$product, $limit = NULL, $size = NULL) {
        
        $sql = "select id, tamanho, caminho, ordem, legenda from produtos_fotos 
            where produto_id = ? " . ($size != NULL ? ' and tamanho = ?' : '') .
                "order by ordem, tamanho ".($limit!==NULL?' LIMIT ? ':'');

        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $product->getId(), PreparedStatement::INTEGER);
        
        if ($size != null) {
            $p->setParameter(2, $size, PreparedStatement::INTEGER);
        }
        
        if($limit !== NULL){
            $p->setParameter(($size != null?3:2), $limit, PreparedStatement::INTEGER);
        }
        
        $rs = $p->execute();
        $lastOrder = NULL;
        $images = array();
        $i = 0 ;
        while ($rs->next()) {
            $arr = $rs->fetchArray();

            if ($lastOrder === NULL) {
                $lastOrder = $arr['ordem'];
                $webImage = new WebImage();
            } else if ($lastOrder != $arr['ordem']) {
                $images[$lastOrder] = $webImage;
                $webImage = new WebImage();
                $lastOrder = $arr['ordem'];
            }
            
            if ($lastOrder == $arr['ordem']) {
                
                $img = new Image($arr['caminho']);
                $img->setLink($arr['caminho']);
                $webImage->setImage($img, $arr['tamanho']);
                
            }
            $i++;
        }
        if($webImage!='' && $i >0){
            $images[$lastOrder] = $webImage;
        }
        
        $product->setImages($images);
        
    }

    public function deleteAllImages(Product &$product, $autoCommit = true) {
        if ($autoCommit) {
            $this->begin();
        }

        $sql = "delete from produtos_fotos where produto_id = ? ";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $product->getId(), PreparedStatement::INTEGER);
        $p->execute();

        if ($autoCommit) {
            $this->commit();
        }
    }

    public function saveImages(Product &$product) {
        $i = 0;
        foreach ($product->getImages() as $k => $webimg) {
            foreach ($webimg->getImages() as $tamanho => $img) {
                $sql = "INSERT INTO produtos_fotos(produto_id, ordem, tamanho, caminho, legenda)
                        VALUES (?,?,?,?,?)";
                $p = $this->getConn()->prepare($sql);
                $p->setParameter(1, $product->getId(), PreparedStatement::INTEGER);
                $p->setParameter(2, $k, PreparedStatement::INTEGER);
                $p->setParameter(3, $tamanho, PreparedStatement::INTEGER);
                $p->setParameter(4, $img->getLink(), PreparedStatement::STRING);
                $p->setParameter(5, $webimg->getLegend(), PreparedStatement::STRING);
                $p->execute();
            }
            $i++;
        }
    }

    /**
     * 
     * @param integer $id
     * @return Product
     */
    public function getById($id) {
        $prd = parent::getById($id);
        $this->getImages($prd);
        return $prd;
    }

}

?>
