<?php
import('WebImage.php');
import('Category.php');
import('interfaces/ILogicalDeletion.php');
/**
 * Description of Product
 *
 * @author luis
 * @since Jul 26, 2012
 */
class Product implements ILogicalDeletion, Entity
{

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

    /**
     *
     * @var Category
     */
    private $category;

    /**
     *
     * @var boolean
     */
    private $status;

    /**
     *
     * @var boolean
     */
    private $showIndex = false;

    public function getSellValue()
    {
        return $this->sellValue;
    }

    public function setSellValue($sellValue)
    {
        $this->sellValue = $sellValue;
    }

    function __construct()
    {
        $this->images = array();
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return List<WebImage>
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     *
     * @param List<WebImage> $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    public function addImage(WebImage $img, $order = NULL)
    {
        if ($order != NULL) {
            $this->images[$order] = $img;
        } else {
            $this->images[] = $img;
        }
    }

    /**
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     *
     * @param Category $category
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    /**
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *
     * @return boolean
     */
    public function getShowIndex()
    {
        return $this->showIndex;
    }

    /**
     *
     * @param boolean $showIndex
     */
    public function setShowIndex($showIndex)
    {
        $this->showIndex = $showIndex;
    }


}

?>
