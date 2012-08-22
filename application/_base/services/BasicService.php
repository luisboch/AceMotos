<?php
import('interfaces/IBasicService.php');
/**
 *
 * @author luis.boch
 * @since Jun 23, 2012
 */
abstract class BasicService implements IBasicService{
    /**
     *
     * @var BasicDAO
     */
    protected $dao;
    function __construct(BasicDAO $dao) {
        $this->dao = $dao;
    }

    /**
     *
     * @param Entity $entity 
     * @return void
     */
    public function delete(Entity &$entity) {
        $this->dao->begin();
        $this->dao->delete($entity, false);
        $this->dao->commit();
    }

    /**
     *
     * @param type $id
     * @return Entity
     */
    public function getById($id) {
        return $this->dao->getById($id);
    }

    /**
     *
     * @param Entity $entity 
     * @throws ValidationException
     * @return void
     */
    public function save(Entity &$entity) {
        $this->validate($entity);
        $this->dao->begin();
        $this->dao->save($entity,false);
        $this->dao->commit();
    }

    /**
     *
     * @param Entity $entity 
     * @throws ValidationException
     * @return void
     */
    public function update(Entity &$entity) {
        $this->validate($entity);
        $this->dao->begin();
        $this->dao->update($entity,false);
        $this->dao->commit();
    }
    
    public function search($string, $start = NULL, $limit = NULL) {
        if($limit ===NULL || $start ===NULL){
            return $this->dao->search($string);
        }
        return $this->dao->paginationSearch($string, $start , $limit );
    }
    
    public function count($string){
        return $this->dao->count($string);
    }

    /**
      *
      * @param Entity $entity
      * @throws ValidationException 
      */
     protected function validate(Entity &$entity){
     }
}

?>
