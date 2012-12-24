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
        if ($str === NULL) {
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
            if (!is_array($file['name'])) {
                return array($this->_upload($file));
            } else {
                $files = array();
                for ($i = 0; $i < count($file['name']); $i++) {
                    if ($file['name'][$i] != '') {
                        $f = array();
                        foreach ($file as $k => $v) {
                            $f[$k] = $file[$k][$i];
                        }
                        $files[$i] = $this->_upload($f);
                    }
                }
                return $files;
            }
        }
    }

    private function getExtension($string) {
        $exp = explode('.', $string);
        return '.' . $exp[count($exp) - 1];
    }

    private function _upload($file) {
        if ($file == null || $file['error'] != '') {
            throw new FileUploadException("Houve um erro ao fazer o upload!");
        }
        $time = time();
        $i = 0;
        $ext = $this->getExtension($file['name']);
        $destination = $this->path . $file['name'] . $time . 't_' . $i . $ext;
        while (file_exists($destination)) {
            $i++;
            $destination = $this->path . $file['name'] . $time . 't_' . $i . $ext;
        }
        if(!move_uploaded_file($file['tmp_name'], $destination)){
            throw new FileUploadException(
                    "Não foi possível realizar o upload [Mover para pasta específicada]");
        };

        return new File($destination);
    }

}

?>
