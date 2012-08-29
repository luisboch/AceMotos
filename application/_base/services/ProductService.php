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

    /**
     * 
     * @param Product $product
     * @param type $images
     * @return Product
     */
    public function &saveImages(Product &$product, &$images) {
        $this->dao->begin();

        foreach ($product->getImages() as $k => $image) {
            if (array_key_exists($k, $images)) {
                $image->delete();
            } else {
                $images[$k] = $image;
            }
        }

        $this->dao->deleteAllImages($product, false);

        $product->setImages($images);

        $this->dao->update($product);

        $this->dao->commit();
        return $product;
    }

    /**
     * 
     * @param Product $product
     * @param integer $index
     * @return Product
     */
    public function &removeImage(Product &$product, $index) {
        $images = &$product->getImages();

        $webImage = &$images[$index];

        $webImage->delete();

        unset($images[$index]);
        $this->dao->deleteAllImages($product, false);
        $product->setImages($images);
        $this->update($product);
        return $product;
    }

}

?>
