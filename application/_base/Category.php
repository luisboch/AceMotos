<?php

/**
 * Description of Category
 *
 * @author luis
 * @since Jul 25, 2012
 */
class Category implements Entity {
    private $id;
    private $description;
    
    /**
     * @var Category parent;
     */
    private $category;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @return Category
     */
    public function getCategory() {
        return $this->category;
    }

    public function setCategory(Category $category) {
        $this->category = $category;
    }
    
    public function equals($category){
        if($category == null){
            return false;
        }
        if(!$category instanceof Category){
            return false;
        }
        if($category->getId() == $this->getId()){
            return true;
        }
        return false;
        
    }

}

?>
