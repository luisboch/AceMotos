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
    
    /**
     *
     * @var List<WebImage>
     */
    private $images;
    
    
    public function getSellValue() {
        return $this->sellValue;
    }

    public function setSellValue($sellValue) {
        $this->sellValue = $sellValue;
    }

    function __construct() {
        $this->images = array();
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
     * @return List<WebImage>
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * 
     * @param List<WebImage> $images
     */
    public function setImages($images) {
        $this->images = $images;
    }
    public function addImage(WebImage $img, $order = NULL){
        if($order != NULL){
            $this->images[$order] = $img;
        } else {
            $this->images[] = $img;
        }
    }


}

?>
