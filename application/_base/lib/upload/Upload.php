<?php

import('lib/upload/File.php');
import('exceptions/FileUploadException.php');
import('lib/upload/qqUpload/qqUpload.php');

/**
 * Description of Upload
 *
 * @author luis
 * @since Jul 28, 2012
 */
class Upload {

    private $path;

    /**
     *
     * @var File 
     */
    private $file;

    function __construct() {
        $this->path = BASE_APPLICATION . 'resources/uploads/';
        $this->listeners = array();
    }

    /**
     * 
     * @return string path of uploads
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Uploads file to folder /resources/uploads
     * @param string $str is key of var $_FILES
     * @return File the uploaded file
     */
    public function upload($str = NULL) {
        if($str === NULL){
            $str = 'qqfile';
        }
        if ($str == 'qqfile') {
            if ($_GET['qqfile'] == '' && $_FILES['qqfile'] == '') {
                throw new FileUploadException('Fail to receive qqfile');
            }
            $uploader = new qqFileUploader(array(), 10 * 1024 * 1024);
            $ob = $uploader->handleUpload($this->path);
            
            exit;
            return $ob;
        } else {
            $file = $_FILES[$str];
            if ($file == null || $file['error'] != '') {
                throw new FileUploadException("Houve um erro ao fazer o upload!");
            }
            $time = time();
            $i = 0;
            $ext =$this->getExtension($file['name']);
            $destination = $this->path . $file['name'] . $time . 't_' . $i . $ext;
            while (file_exists($destination)) {
                $i++;
                $destination = $this->path . $file['name'] . $time . 't_' . $i . $ext;
            }
            move_uploaded_file($file['tmp_name'], $destination);

            return new File($destination);
        }
    }

    private function getExtension($string) {
        $exp = explode('.', $string);
        return '.' . $exp[count($exp) - 1];
    }

}

?>
