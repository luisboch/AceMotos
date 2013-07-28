<?php

import('util/StringUtil.php');

/**
 * Description of File
 *
 * @author luis
 * @since Jul 28, 2012
 */
class File
{

    private $size;
    private $fullPath;
    private $mimeType;
    private $simpleName;

    function __construct($fullPath)
    {
        $this->fullPath = $fullPath;
        $this->size = filesize($fullPath);
        if($this->size === false){
            throw new IllegalStateException("Failed to get size of File: \n".$this->fullPath);
        }
        $this->simpleName = $this->getFileName();
        $this->mimeType = mime_content_type($fullPath);
        
        if($this->mimeType === false){
            throw new IllegalStateException("Failed to get mimetype of File: ".$this->fullPath);
        }
    }

    function exists()
    {
        return file_exists($this->fullPath);
    }

    /**
     * @param string $dir
     * @return boolean
     */
    function  moveTo($dir)
    {

        if (is_dir($dir)) {

            if (!is_writable($dir)) {
                return false;
            }

            if (!StringUtil::endsWith($dir, '/')) {
                $dir = $dir . '/';
            }

            $targetFile = $dir . $this->simpleName;

            while (file_exists($targetFile)) {
                $targetFile = $dir . time() . $this->simpleName;
            }

            rename($this->fullPath, $targetFile);
            $this->fullPath = $targetFile;
            $this->simpleName = $this->getFileName();

            return true;
        } else {
            if (!is_writable(dirname($dir))) {
                return false;
            }
            rename($this->fullPath, $dir);
            $this->fullPath = $dir;
            $this->simpleName = $this->getFileName();
            return true;
        }
    }

    function getDir()
    {
        return dirname($this->fullPath);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getFullPath()
    {
        return $this->fullPath;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getSimpleName()
    {
        return $this->simpleName;
    }

    private function getFileName()
    {
        $pos1 = strrpos($this->fullPath, '/');
        return substr($this->fullPath, $pos1 + 1);
    }

    /**
     * @return boolean
     */
    public function isImage()
    {
        $arr = explode('/', $this->mimeType);
        return $arr[0] == 'image';
    }

    /**
     * try delete a file, if found error thows Exception
     * @throws Exception
     */
    public function delete()
    {
        if (unlink($this->fullPath)) {
            $this->fullPath = '';
            $this->mimeType = '';
            $this->simpleName = '';
            $this->size = 0;
        } else {
            throw new Exception('Check write Access to delete file!');
        }
    }
}

?>
