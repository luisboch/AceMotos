<?php
/**
 *
 * @author felipe
 */
class Notice implements Entity{
    //put your code here
    
    private $id;
    private $title;
    private $resume;
    private $notice;
    /**
     *
     * @var WebImage
     */
    private $webImage;
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getNotice() {
        return $this->notice;
    }

    public function setNotice($notice) {
        $this->notice = $notice;
    }

    
        public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getResume() {
        return $this->resume;
    }

    public function setResume($resume) {
        $this->resume = $resume;
    }
    
    /**
     * 
     * @return WebImage
     */
    public function getWebImage() {
        return $this->webImage;
    }

    /**
     * 
     * @param WebImage $webImage
     */
    public function setWebImage(WebImage $webImage) {
        $this->webImage = $webImage;
    }


}

?>
