<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('simpleUpload')) {



    function multipleUpload($images, $name, $targetRemove, $entityId,  $id = NULL, $options = array()) {
        if ($id == NULL) {
            $id = 'multipleUpload_' . time();
        }
        $options['class'] = 'multiple-upload ' . $options['class'];
        $opts = getOptions($options);


        if (!is_array($images)) {
            if ($images != '') {
                throw new ErrorException("param [\$images] must be a list of WebImage instances!");
            }
            $images = array();
        }
        $html = "<div " . $opts . " >
            ";
        $html .= '<div class="multiple-upload-header ui-state-default ui-widget-header">Alterar imagens</div>
            ';
        $html .= '<div class="multiple-upload-header">
                    <div class="multiple-upload-header-column ui-state-default ui-widget-header">Imagem Atual</div>
                    <div class="multiple-upload-header-column ui-state-default ui-widget-header">Nova Imagem</div>
                  <span style="clear:both;"></span>
                  </div>
                  ';
        for ($i = 0; $i < 10; $i++) {
            $html .= "<div class=\"multiple-upload-rows\">
                ";
            $image = $images[$i];
            $html .= '<div class="old-image">' . adminimage($image, 1) . '</div>
                    ';
            if($image!=''){
                $html.='<div class="image-remove"><a href="'.  $targetRemove.'/'.$entityId.'?i='. $i .'">excluir</a></div>';
            } else {
                $html .= '<div class="image-remove"></div>';
            }
            $html .= '<div class="new-image"><input type="file" name="' . $name . '[' . $i . ']"></div>
                <div style="clear:both;width:100%;height:4px;float:none"></div>
                ';
            $html .= '</div>
                ';
        }
        $html .= '</div>
            ';
        return $html;
    }

}
?>
