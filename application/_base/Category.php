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

    /**
     *
     * @var array
     */
    private $children = array();

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
        $category->children[] = $this;
    }

    /**
     * @return Category[]
     */
    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

    public function equals($category) {
        if ($category == null) {
            return false;
        }
        if (!$category instanceof Category) {
            return false;
        }
        if ($category->getId() == $this->getId()) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function isRoot() {
        return $this->category == null;
    }

}

?>
