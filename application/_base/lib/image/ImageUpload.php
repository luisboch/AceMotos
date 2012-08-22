<?php

import('util/StringUtil.php');
import('lib/image/Canvas.php');
import('lib/image/Image.php');
import('WebImage.php');
import('lib/upload/Upload.php');
import('lib/image/ImageManipulation.php');

/**
 * Class used to integrate uploads to a dinamic file upload
 *
 * @author luis
 * @since Jul 28, 2012
 */
class ImageUpload{

    private $path;

    /**
     *
     * @var Upload
     */
    private $upload;

    /**
     *
     * @var ImageManipulation
     */
    private $imageManipulation;

    function __construct($librarie) {
        $this->listeners = array();
        $this->upload = new Upload();

        if (StringUtil::startsWith($librarie, '/')) {
            $librarie = substr($librarie, 1);
        }

        if (!StringUtil::endsWith($librarie, '/')) {
            $librarie = $librarie . '/';
        }

        $this->imageManipulation = new ImageManipulation();
        $this->path = BASE_IMAGES . $librarie;
    }
    /**
     * 
     * @param type $fileName
     * @return WebImage ImageUploaded
     */
    public function upload($fileName = NULL) {

        $file = $this->upload->upload($fileName);
        if ($file->isImage()) {
            $file->moveTo($this->path);
            $img = new Image($file);
            
            $imgs[5]=$this->imageManipulation
                    ->setImage($img)->resize(array('width' => 1024))
                    ->save(array('copy' => true));
            $imgs[4]=$this->imageManipulation->resize(array('width' => 800))
                    ->save(array('copy' => true));
            $imgs[3]=$this->imageManipulation->resize(array('width' => 500))
                    ->save(array('copy' => true));
            $imgs[2]=$this->imageManipulation->resize(array('width' => 250))
                    ->save(array('copy' => true));
            $imgs[1]=$this->imageManipulation->resize(array('width' => 100))
                    ->save(array('copy' => true));
            $imgs[0]=$this->imageManipulation->resize(array('width' => 50))
                    ->save(array('copy' => true));
            $webImage = new WebImage();
            
            foreach($imgs as $k => $i){
                $webImage->setImage($i, $k);
            }
            
            $file->delete();
            return $webImage;

        }
    }

}

?>
