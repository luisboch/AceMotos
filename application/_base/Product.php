<?php

/**
 * Description of Product
 *
 * @author luis
 * @since Jul 26, 2012
 */
class Product implements Entity {

    /**
     *
     * @var integer 
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string 
     */
    private $description;

    /**
     *
     * @var array<ProductImage> 
     */
    
    private $sellValue;
    
    
    public function getSellValue() {
        return $this->sellValue;
    }

    public function setSellValue($sellValue) {
        $this->sellValue = $sellValue;
    }

        private $images = array();

    function __construct() {
        
    }

    /**
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param integer $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @return array<ProductImage>
     */
    public function &getImages() {
        return $this->images;
    }

    /**
     * 
     * @param array<ProductImage> $images
     */
    public function setImages(&$images) {
        $this->images = $images;
    }

    public function addImage(Image $img) {
        if ($img->getProduct() == null ||
                $img->getProduct()->getId() != $this->getId()) {
            $img->setProduct($prduct);
        }
    }

}

?>
