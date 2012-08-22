<?php

import('util/StringUtil.php');

/**
 * Description of File
 *
 * @author luis
 * @since Jul 28, 2012
 */
class File {

    private $size;
    private $cannonicalPatch;
    private $mimeType;
    private $simpleName;

    function __construct($cannonicalPatch) {
        $this->cannonicalPatch = $cannonicalPatch;
        $this->size = filesize($cannonicalPatch);
        $this->simpleName = $this->getFileName();
        $this->mimeType = mime_content_type($cannonicalPatch);
    }

    function exists() {
        return file_exists($this->cannonicalPatch);
    }
    /**
     * @param string $dir
     * @return boolean
     */
    function  moveTo($dir) {
        
        if (is_dir($dir)) {
            
            if(!is_writable($dir)){
                return false;
            }
            
            if (!StringUtil::endsWith($dir, '/')) {
                $dir = $dir . '/';
            }
            
            $targetFile = $dir . $this->simpleName;
            
            while (file_exists($targetFile)){
                $targetFile = $dir.time().$this->simpleName;
            }
            
            rename($this->cannonicalPatch, $targetFile);
            $this->cannonicalPatch = $targetFile;
            $this->simpleName = $this->getFileName();
            
            return true;
        } else {
            if(!is_writable(dirname($dir))){
                return false;
            }
            rename($this->cannonicalPatch,$dir);
            $this->cannonicalPatch = $dir;
            $this->simpleName = $this->getFileName();
            return true;
        }
    }
    function getDir(){
        return dirname($this->cannonicalPatch);
    }
    public function getSize() {
        return $this->size;
    }

    public function getCannonicalPatch() {
        return $this->cannonicalPatch;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function getSimpleName() {
        return $this->simpleName;
    }
    
    private function getFileName(){
        $pos1 = strrpos($this->cannonicalPatch, '/'); 
        return substr($this->cannonicalPatch, $pos1+1);
    }
    /**
     * @return boolean
     */
    public function isImage(){
        $arr = explode('/', $this->mimeType);
        return $arr[0] == 'image';
    }

    /**
     * try delete a file, if found error thows Exception
     * @throws Exception
     */
    public function delete(){
        if(unlink($this->cannonicalPatch)){
           $this->cannonicalPatch = '';
           $this->mimeType = '';
           $this->simpleName='';
           $this->size = 0;
        }
        else{
            throw new Exception('Check write Access to delete file!');
        }
    }
}

?>
