<?

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('simpleUpload')) {


    function simpleUpload($action, $name, $id = NULL, $options = array())
    {
        if ($id == NULL) {
            $id = 'simpleUpload_' . time();
        }
        $options['class'] = 'simple-upload ' . $options['class'];
        $opts = getOptions($options);
        return '
            

            <div>
            <input type="file" target="output" ' . $opts . '
            name="' . $name . '" id="' . $id . '" 
                rel="' . $action . '" /><input class="ui-button" type="submit" 
                    value="fazer upload"/></div>
            ';
    }

}
?>
