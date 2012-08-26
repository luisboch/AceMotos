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

        if ($entity->getName() == '') {
            $ve->addError('Por Favor Preencha o nome corretamente', 'name');
        }


        if ($entity->getSellValue() == '') {
            $ve->addError('Por Favor Preencha o valor de venda corretamente', 'sellValue');
        }

        if (!$ve->isEmtpy()) {
            throw $ve;
        }
    }

    public function getImages(Product &$product, $limit = 10, $size = NULL) {
        return $this->dao->getImages($product, $limit, $size);
    }

}

?>
