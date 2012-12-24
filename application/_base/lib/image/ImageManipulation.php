<?php

/**
 * Description of ImageManipulation
 *
 * @author luis
 * @since Jul 28, 2012
 */
class ImageManipulation {

    /**
     *
     * @var Image 
     */
    private $image;
    private $warns = array();
    private $types = array('jpg', 'jpeg', 'gif', 'png');

    function __construct(&$image = NULL) {
        if ($image != null) {
            if ($image instanceof Image) {
                if ($this->checkImage($image)) {
                    $this->image = $image;
                }
            } else{
                $this->image = new Image($image);
            }
        }
    }

    /**
     * check if mime tipe of image is allowed to edit
     * @param Image $img
     * @return boolean return true if is allowed, false otherwise
     */
    public function checkImage(Image $img) {
        $mime = $img->getFile()->getMimeType();
        $mime = explode('/', $mime);
        if ($mime[0] != 'image' || !in_array($mime[1], $this->types)) {
            $this->warns[] = new ImageManipulationWarn($img,
                            'This type(' . $mime[1] . ') is not allowed (alloweds:[' . implode(', ', $this->types) . '])');
            return false;
        }
        return true;
    }

    /**
     * @param Image $image
     * @return ImageManipulation
     */
    public function setImage(Image &$image) {
        if ($this->checkImage($image)) {
            $this->image = $image;
        }
        return $this;
    }

    /**
     * @param array $options
     * @return ImageManipulation
     */
    public function save( $options) {
        $image = &$this->image;
        $copy = $options['copy'];
        $override = $options['override'];

        if ($override === NULL) {
            $override = true;
        }

        $local = $image->getFile()->getCannonicalPatch();
        if ($copy) {
            if (file_exists($local)) {
                $dir = dirname($local);
                $i = 0;
                $time = time();
                $type = strtolower($image->getSimpleType());
                while (file_exists($local =
                        $dir . '/' . $time  . '_im' . $i . '.' . $type)) {
                    $i++;
                }
            }
            
            imagejpeg($image->getImageSample(), $local);
        } else {
            if (!$override) {
                if (file_exists($local)) {
                    $dir = dirname($local);
                    $i = 0;
                    $type = strtolower($image->getSimpleType());
                    while (file_exists($local =
                            $dir . '/' . time() . '_im' . $i . '.' . $type)) {
                        $i++;
                    }
                }
            }
            imagejpeg($image->getImageSample(), $local);
        }
        return new Image($local);
    }


    public function resize($options) {
        $image = &$this->image;
        $new_height = $options['heigth'];
        $new_width = $options['width'];
        $scale = $options['scale'];

        if ($new_height != '' && $new_width != '') {
            $this->resizeToWidthAndHeight($new_width, $new_height);
        } else if ($scale != '') {
            $this->scale( $scale);
        } else if ($new_height != '') {
            $ratio = $new_height / $image->getHeight();
            $width = $image->getWidth() * $ratio;
            $this->resizeToWidthAndHeight($width, $new_height);
        } else if ($new_width != '') {
            $ratio = $new_width / $image->getWidth();
            $height = $image->getHeight() * $ratio;
            $this->resizeToWidthAndHeight( $new_width, $height);
        }
        return $this;
    }

    public function scale( $scale) {
        $image = &$this->image;
        $width = $image->getWidth() * $scale / 100;
        $height = $image->getHeight() * $scale / 100;
        $this->resizeToWidthAndHeight($image, $width, $height);
    }

    private function resizeToWidthAndHeight( $width, $height) {
        $image = &$this->image;
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $image->getImageSample(), 0, 0, 0, 0, $width, $height, $image->getWidth(), $image->getHeight());
        $image->setImageSample($new_image);
    }

    /**
     * 
     * @return List<ImageManipulationWarn>
     */
    public function getWarns() {
        return $this->warns;
    }
    
    public function getImage() {
        return $this->image;
    }


}

class ImageManipulationWarn {

    private $image;
    private $description;

    function __construct(Image $image, $description) {
        $this->image = $image;
        $this->description = $description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getDescription() {
        return $this->description;
    }

}

?>
