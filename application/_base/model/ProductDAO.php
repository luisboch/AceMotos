<?php

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
import('Category.php');
import('Product.php');
import('model/BasicDAO.php');

class ProductDAO extends BasicDAO {

    //put your code here

    function __construct() {
        $this->setTableName(" `produtos` ");
    }
    
    protected function executeInsert(Entity &$entity) {

        $sql = "insert into " . $this->getTableName() . " (" . $this->getFields() . ", categoria_id ) values (?,?,?,?,true,?,?)";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->setParameter(2, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getSellValue(), PreparedStatement::DOUBLE);
        $p->setParameter(5, $entity->getShowIndex(), PreparedStatement::BOOLEAN);
        $p->setParameter(6, $entity->getCategory()->getId(), PreparedStatement::INTEGER);
        $p->execute();
        $entity->setId($this->getConn()->lastId());
    }

    protected function executeUpdate(Entity &$entity) {

        $sql = "UPDATE " . $this->getTableName() . " 
                    SET `nome`=?,
                        `descricao`=?,
                        `valor_venda`=?, 
                        `categoria_id`=?,
                        `status`=?,
                        `exibir_index`=?
                    WHERE id=?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getDescription(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getSellValue(), PreparedStatement::DOUBLE);
        $p->setParameter(4, $entity->getCategory()->getId(), PreparedStatement::INTEGER);
        $p->setParameter(5, $entity->getStatus(), PreparedStatement::BOOLEAN);
        $p->setParameter(6, $entity->getShowIndex(), PreparedStatement::INTEGER);
        $p->setParameter(7, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();

        $this->deleteAllImages($entity, false);
        $this->saveImages($entity, false);
    }

    public function getFields() {
        return ' `id`, `nome`, `descricao`, `valor_venda`, `status`, `exibir_index` ';
    }

    /**
     *
     * @param ResultSet $rs
     * @return Product
     */
    public function getObject(ResultSet &$rs) {
        $arr = $rs->fetchArray();
        return $this->buildObject($arr);
    }
    
    /**
     * Build object by given array.
     * @param type $arr
     * @return Product
     */
    public function buildObject(&$arr) {
        
        $product = new Product();
        $product->setId($arr['id']);
        $product->setName($arr['nome']);
        $product->setDescription($arr['descricao']);
        $product->setSellValue($arr['valor_venda']);
        $product->setStatus($arr['status']);
        $product->setShowIndex($arr['exibir_index']);

        return $product;
    }

    public function search($string) {
        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where id = ? or nome like ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $arr[] = & $this->getObject($rs);
        }

        return $arr;
    }

    public function count($string) {
        $sql = 'select count(*) as qtd from ' . $this->getTableName()
                . ' where ( id = ? or nome like ? ) and status = true';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $rs->next();
        $arr = $rs->fetchAssoc();
        return $arr['qtd'];
    }

    public function paginationSearch($string, $start = NULL, $limit = NULL) {

        if ($start === NULL || $limit === NULL) {
            return $this->search($string);
        }

        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where  ( id = ? or nome like ? ) and status = true LIMIT ' . $start . ', ' . $limit;
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);
        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $ob = & $this->getObject($rs);
            $this->getImages($ob, 1, 0);
            $arr[] = $ob;
        }
        return $arr;
    }

    public function indexSearch() {
        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
                . ' where  status = true and exibir_index = true LIMIT 0, 25';
        $p = $this->getConn()->prepare($sql);
        $rs = $p->execute();
        $arr = array();
        while ($rs->next()) {
            $ob = & $this->getObject($rs);
            $this->getImages($ob, 1, 0);
            $arr[] = $ob;
        }
        return $arr;
    }

    /**
     * 
     * @param Product $product
     * @param type $limit
     * @param type $size
     * @return void 
     */
    public function getImages(Product &$product, $limit = NULL, $size = NULL) {

        $sql = "select id, tamanho, caminho, ordem, legenda from produtos_fotos 
            where produto_id = ? " . ($size != NULL ? ' and tamanho = ?' : '') .
                "order by ordem, tamanho " . ($limit !== NULL ? ' LIMIT ? ' : '');

        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $product->getId(), PreparedStatement::INTEGER);

        if ($size != null) {
            $p->setParameter(2, $size, PreparedStatement::INTEGER);
        }

        if ($limit !== NULL) {
            $p->setParameter(($size != null ? 3 : 2), ($limit * 6), PreparedStatement::INTEGER);
        }

        $rs = $p->execute();
        $lastOrder = NULL;
        $images = array();
        $i = 0;
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
        if ($webImage != '' && $i > 0) {
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
        $sql = "
            select p.`id`, p.`nome`, p.`descricao`, p.`valor_venda`, 
                   p.`categoria_id`, c1.id as cat1id, c1.descricao as cat1desc, 
                   c2.id as cat2id, c2.descricao as cat2desc, p.`status`, p.`exibir_index`
              from produtos p
              join categorias c1 on (c1.id = p.`categoria_id` )
              join categorias c2 on (c2.id = c1.`categoria_id` )
             where p.id=? and status = true";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $id, PreparedStatement::INTEGER);
        $rs = $p->execute();
        if ($rs->getNumRows() != 1) {
            throw new NoResultException('Product not found with id:' . $id);
        }

        $rs->next();

        $arr = $rs->fetchArray();
        $cat1 = new Category();
        $cat1->setDescription($arr['cat1desc']);
        $cat1->setId($arr['cat1id']);

        $cat2 = new Category();
        $cat2->setDescription($arr['cat2desc']);
        $cat2->setId($arr['cat2id']);
        $cat1->setCategory($cat2);

        $prd = $this->buildObject($arr);
        $prd->setCategory($cat1);

        $this->getImages($prd);

        return $prd;
    }

    public function getProductsByCategory(Category $category) {
        $sql = "
            select p.`id`, p.`nome`, p.`descricao`, p.`valor_venda`, 
                   p.`categoria_id`, c1.id as cat1id, c1.descricao as cat1desc, 
                   c2.id as cat2id, c2.descricao as cat2desc, p.`status`, p.`exibir_index`
              from produtos p
              join categorias c1 on (c1.id = p.`categoria_id` )
              join categorias c2 on (c2.id = c1.`categoria_id` )
             where (c1.id = ? or c2.id = ?)
               and p.status = true
               and 5 < (select count(id) from produtos_fotos where produto_id = p.id)";
        
        $p = $this->getConn()->prepare($sql);
        
        $p->setParameter(1, $category->getId(), PreparedStatement::INTEGER);
        $p->setParameter(2, $category->getId(), PreparedStatement::INTEGER);
        
        $result = $p->getResult();
        
        $arr = array();
        
        while ($result->next()) {
            $ob = $this->getObject($result);   
            $this->getImages($ob, 1, 0);
            $arr[] = $ob;
        }
        return $arr;
    }

    /**
     * 
     * @param type $string
     * @return List<Product>
     */
    public function viewSearch($string) {
        if($string == ""){
            return array();
        }
        $sql = '
            select p.`id`, p.`nome`, p.`descricao`, p.`valor_venda`, 
                   p.`categoria_id`, c1.id as cat1id, c1.descricao as cat1desc, 
                   c2.id as cat2id, c2.descricao as cat2desc, p.`status`, p.`exibir_index` 
              from ' . $this->getTableName(). ' p
              join categorias c1 on (c1.id = p.categoria_id)
              join categorias c2 on (c2.id = c1.categoria_id)
             where p.status = true and 
                   (  p.id = ? 
                      or lower(nome) like lower(?) 
                      or lower(c1.descricao) like lower(?) 
                      or lower(c2.descricao) like lower(?)
                   )';
        
        
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, '%' . $string . '%', PreparedStatement::STRING);
        $p->setParameter(3, '%' . $string . '%', PreparedStatement::STRING);
        $p->setParameter(4, '%' . $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $ob = $this->getObject($rs);
            $this->getImages($ob, 1, 0);
            $arr[] = $ob;
        }

        return $arr;
    }
}
?>