<?php
import('Product.php');
import('lib/image/Image.php');
import('lib/image/Image.php');
/**
 * Description of WebImage
 *
 * @author luis
 * @since Jul 28, 2012
 */
class WebImage {
    

    private $id;
    private $imgs = array();
    private $legend;
    
    function __construct($param = array()) {
        foreach($param as $k => $v){
            if(is_object($v) && $v instanceof Image){
                $this->imgs[$k] = $v;
            }
            else if (is_string($v)){
                $this->imgs[$k] = new Image($v);
            }
        }
    }

        public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    /**
     * 
     * @param integer $index
     * @return Image
     */
    public function getImage($index) {
        return $this->imgs[$index];
    }
    
    /**
     * 
     * @return array<Image>
     */
    public function getImages() {
        return $this->imgs;
    }

    public function setImage(Image $img, $index) {
        $this->imgs[$index] = $img;
    }
    
    public function delete(){
        foreach($this->imgs as $ob){
            $ob->getFile()->delete();
        }
    }


    public function getLegend() {
        return $this->legend;
    }

    public function setLegend($legend) {
        $this->legend = $legend;
    }


}

?>
