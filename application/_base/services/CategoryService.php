<?php

import('model/CategoryDAO.php');
import('services/BasicService.php');
import('exceptions/ValidationException.php');
/**
 *
 * @author felipe
 * @since Jul 22, 2012
 */
class CategoryService extends BasicService{
    //put your code here
    
    function __construct() {
        
        parent:: __construct(new CategoryDAO());
        
    }

    protected function validate(Entity &$entity) {
        
        $ve = new ValidationException();
        
        if($entity->getDescription() == '' ){
            $ve->addError('Por Favor Preencha a descricao corretamente', 'description');
        }
        
        if(!$ve->isEmtpy()){
            throw $ve;
        }
    }
    
    public function searchByParent(Category $parent){
        return $this->dao->searchByParent($parent);
    }
    
    public function getRootCategories(){
        return $this->dao->getRootCategories();
    }
    
}

?>
