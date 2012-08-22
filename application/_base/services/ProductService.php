<?php

import('model/ProductDAO.php');
import('services/BasicService.php');
import('exceptions/ValidationException.php');

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */

class ProductService extends BasicService {
    //put your code here
    function __construct() {
        
        parent:: __construct(new ProductDAO());
        
    }

    protected function validate(Entity &$entity) {
        
        $ve = new ValidationException();
        $entity = new Product();
        if($entity->getName() == '' ){
            $ve->addError('Por Favor Preencha o nome corretamente', 'name');
        }
        
       
        if($entity->getSellValue() == ''){
            $ve->addError('Por Favor Preencha o valor de venda corretamente', 'sellValue');
        }
        
        if(!$ve->isEmtpy()){
            throw $ve;
        }
    }
    
}

?>
