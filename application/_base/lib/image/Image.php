<?php
import('lib/upload/File.php');
/**
 * @author luis
 * @since Jul 26, 2012
 */
class Image
{


    /**
     *
     * @var File
     */
    private $file;
    private $imageSample;
    private $simpleType;
    private $link;

    function __construct($file = NULL)
    {
        if ($file !== NULL) {
            if ($file instanceof File) {
                $this->setFile($file);
            } else {
                $this->setLink($file);
            }
        }
    }

    /**
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->imageSample = '';
        $this->file = $file;
        $this->loadFile();
    }

    /**
     * @param File $file
     */
    public function setLink($link)
    {
        $this->imageSample = '';
        $link = str_replace(BASE_IMAGES, '', $link);
        $this->link = $link;
        $this->loadFile();
    }

    public function createImageSample()
    {
        if ($this->simpleType == '') {
            $this->loadFile();
        }
        if ($this->imageSample == '') {

            switch ($this->simpleType) {
                case 'JPG':
                    $this->imageSample = imagecreatefromjpeg($this->file->getCannonicalPatch());
                    break;
                case 'PNG':
                    $this->imageSample = imagecreatefrompng($this->file->getCannonicalPatch());
                    break;
                case 'GIF':
                    $this->imageSample = imagecreatefromgif($this->file->getCannonicalPatch());
                    break;
            }
        }
    }

    public function loadFile()
    {
        if ($this->file != '') {
            $this->link = str_replace(BASE_IMAGES, '', $this->file->getCannonicalPatch());
        } else if ($this->link != '') {
            $this->file = new File(BASE_IMAGES . $this->link);
        } else {
            throw new InvalidArgumentException("file or link need be defined!");
        }

        $list = getimagesize($this->file->getCannonicalPatch());
        if ($list[2] == IMAGETYPE_JPEG) {
            $this->simpleType = 'JPG';
        } else if ($list[2] == IMAGETYPE_GIF) {
            $this->simpleType = 'GIF';
        } else if ($list[2] == IIMAGETYPE_PNG) {
            $this->simpleType = 'PNG';
        }
    }

    function getWidth()
    {
        $this->createImageSample();
        return imagesx($this->imageSample);
    }

    function getHeight()
    {
        $this->createImageSample();
        return imagesy($this->imageSample);
    }

    public function getImageSample()
    {
        $this->createImageSample();
        return $this->imageSample;
    }

    public function getSimpleType()
    {
        return $this->simpleType;
    }

    public function setImageSample($imageSample)
    {
        $this->imageSample = $imageSample;
    }

    public function getCannonicalPatch()
    {
        return $this->file->getCannonicalPatch();
    }

    public function getLink()
    {
        return $this->link;
    }


}

?>
