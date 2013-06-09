<?php

import('model/BrandDAO.php');
import('services/BasicService.php');
import('exceptions/ValidationException.php');

/**
 *
 * @author felipe
 * @since Aug 4, 2012
 */
class BrandService extends BasicService
{

    //put your code here
    function __construct()
    {

        parent:: __construct(new BrandDAO());
    }

    protected function validate(Entity &$entity)
    {

        /* @var $entity Brand */
        
        $ve = new ValidationException();

        if ($entity->getName() == '') {
            $ve->addError('Por Favor Preencha o nome corretamente', 'name');
        }

        if (!$ve->isEmtpy()) {
            throw $ve;
        }
        
    }
}

?>
