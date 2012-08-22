<?php

import('util/components/GenericButton.php');
import('util/components/Pagination.php');
import('util/Utils.php');
import('util/PHPEL.php');
/**
 * @author luis.boch [luis.c.boch@gmail.com]
 * @since Jul 15, 2012 
 */
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Componente para criação de tabelas populadas com datas
 *
 * @author luis
 */
class DataTable {

    const STRING = 'STR';
    const NUMERIC = 'INT';
    const IMAGE = 'IMG';
    const BOOLEAN = 'BOOL';
    const CURRENCY = 'VLR';
    const FN = 'FN';
    const OPTION_btSearch = 'btSearch';
    const OPTION_urlSearch = 'urlSearch';
    const OPTION_urlCreate = 'urlCreate';
    const OPTION_urlEdit = 'urlEdit';
    const OPTION_title = 'title';
    const OPTION_list = 'list';
    const OPTION_fieldId = 'fieldId';
    /**
     * @deprecated 
     */
    const OPTION_objectId = 'objectId';
    const OPTION_editable = 'editable';
    const OPTION_data = 'data';
    const OPTION_paginate = 'paginate';

    /* required if paginate is true */
    const OPTION_itemsPage = 'itemsPage';
    const OPTION_numLinksPagination = 'numLinksPagination';
    const OPTION_friendyUrlEdit = 'friendyUrlEdit';
    const OPTION_currentPage = 'currentPage';
    const OPTION_amountRegisters = 'amountRegisters';
    const OPTION_amountPerPage = 'amountPerPage';
    const OPTION_targetUrl = 'targetUrl';

    private $htmlPagination = NULL;

    /**
     * @var array objects 
     */
    private $data;

    /**
     *
     * @var array 
     */
    private $options;

    /**
     *
     * @var string 
     */
    private $tableId;

    /**
     *
     * @var integer 
     */
    private static $idCount;

    /**
     *
     * @var Pagination 
     */
    private $pagination;

    /**
     *
     * @param array $options @see STATIC OPTION_*
     */
    function __construct($options = array(), $tableId = NULL
    ) {
        //default option
        $default = array(
            'btSearch' => false,
            'btCreate' => false,
            'urlSearch' => '',
            'urlCreate' => '',
            'urlEdit' => '',
            'title' => '',
            'titleLabels' => array(),
            'fields' => array(),
            'fieldsType' => array(),
            'list' => array(),
            'fieldId' => 'id',
            'objectId' => NULL,
            'editable' => false,
            'data' => NULL,
            'itemsPage' => 10,
            'numLinksPagination' => 5,
            'fieldOptions' => NULL,
            'friendyUrlEdit' => false,
            'paginate' => false,
            'amountPerPage' => 20
        );

        foreach ($default as $k => $v) {
            if ($options[$k] === NULL) {
                $options[$k] = $v;
            }
        }



        $this->options = &$options;

        if ($tableId !== NULL) {
            $this->tableId = $tableId;
        } else {
            if (self::$idCount == '') {
                self::$idCount = 1;
            }
            $this->tableId = 'dataTable_' . self::$idCount;
            self::$idCount++;
        }

        // Pagination 
        if ($this->option(self::OPTION_paginate)) {
            $pag = new Pagination();
            $pag->setTargetUrl($this->option(self::OPTION_targetUrl));
            $pag->setAmountRegisters($this->option(self::OPTION_amountRegisters));
            $pag->setAmountLinkShow($this->option(self::OPTION_numLinksPagination));
            $pag->setAmountPerPage($this->option(self::OPTION_amountPerPage));
            $pag->setCurrentPage($this->option(self::OPTION_currentPage));

            $this->pagination = &$pag;
        }
    }

    public function addDisplayField($label, $field, $type, $option = NULL, $columSize = NULL) {
        $key = count($this->options['fields']);
        $this->options['fieldsType'][$key] = $type;
        $this->options['fields'][$key] = $field;
        $this->options['titleLabels'][$key] = $label;
        $this->options['fieldOptions'][$key] = $label;
        $this->options['columSize'][$key] = $columSize;
    }

    /**
     *
     * @param string $stringKey
     * @return mixed 
     */
    public function option($stringKey) {
        return $this->options[$stringKey];
    }

    private function generatePagination($sizeFields) {
        $string = '<tr><th ' . ($sizeFields > 0 ? 'colspan="' . $sizeFields . '"' : '') . '>';
        $string .= $this->pagination->getHtml();
        $string .= '</th></tr>';
        return $string;
    }

    /**
     * @param type $return
     * @return string 
     */
    public function generate($return = FALSE) {
        $fields = $this->option('fields');
        $types = $this->option('fieldsType');
        $titleLabels = $this->option('titleLabels');

        if (count($fields) != count($titleLabels)) {
            throw new ComponentException("Quantidade de labels
                diverge da quantidade de items a exibir");
        }
        $string = "";
        //se é para exibir botão de pesquisa ou botão de criação 
        if ($this->option("btCreate") || $this->option("btSearch")) {
            $string .= '<div style="text-align: right;width: 90%;
                margin-left:5%;margin-rigth:5%;">';
            if ($this->option("btCreate")) {
                $string .= button("Novo", $this->option('urlCreate'));
            }
            if ($this->option("btSearch")) {

                $string .= button("Pesquisar", $this->option('urlSearch'));
            }
            $string .= "</div>";
        }
        $string .= "<table id=\"" . $this->tableId . "\" class=\"dataTable\">";
        $fieldId = $this->option('fieldId');
        $title = $this->option('title');
        $list = $this->option('list');
        $sizeList = count($list);
        $sizeFields = count($fields);
        $itemsPage = $this->option('itemsPage');

        if ($this->option('editable')) {
            $titleLabels[] = '-';
            $sizeFields++;
        }

        if ($title == '' && $sizeFields == 0) {
            throw new ComponentException("Não há titulo ou campos para exibir");
        }


        $data = $this->option('data');
        if ($data === NULL) {

            $string .= "<thead>";
            if ($title != '') {
                $string .= '<tr><th ' . (
                        $sizeFields != 0 ? 'colspan="' . $sizeFields . '"' : ''
                        ) . ' class="ui-state-default  ui-widget-header" >' . $title . '</th></tr>';
            }

            if ($this->option('paginate')) {
                $this->pagination->setShowing($sizeList);
                $this->htmlPagination = $this->generatePagination($sizeFields);
                $string.=$this->htmlPagination;
            }
            if ($sizeFields != 0) {
                $string .= '<tr>';
                foreach ($titleLabels as $k => $v) {
                    $string .= '<th class="ui-state-default" style="' . ($this->options['columSize'][$k] !== NULL ? 'width:' . $this->options['columSize'][$k] : '') . '" >' . $v . '</th>';
                }
                $string .= '</tr>';
            }

            $string .= '</thead>';
            if ($sizeList != 0) {
                $i = 0;
                $limit = $sizeList;
                $string .= '<tbody>';
                if ($this->option('paginate')) {
                    $limit = $this->option('itemsPage');
                }

                foreach ($list as $obj) {
                    $arrObj = Utils::objectToArray($obj);
                    $aux = '';
                    $aux .= '<tr class="row_data ui-widget-content ui-datatable-odd">';

                    foreach ($fields as $key => $v) {
                        $valueOf = $this->getValue($v, $types[$key], $obj);
                        $aux .= '<td>' . $valueOf . '</td>';
                    }

                    if ($this->option('editable')) {

                        $id = $arrObj[$fieldId];
                        if ($this->option('friendyUrlEdit')) {

                            $aux .= '<td><a class="ui-button" href="'
                                    . $this->option('urlEdit') . '/'
                                    . $id . '"><span class=" ui-icon ui-icon-zoomin" /></a></td>';
                        } else {
                            $aux .= '<td><a class="ui-button"  href="'
                                    . $this->option('urlEdit') . '?' . $fieldId . '='
                                    . $id . '"><span class=" ui-icon ui-icon-zoomin" /></a></td>';
                        }
                    }

                    $aux .= '</tr>';
                    $string .= $aux;

                    $i++;
                }
                $string .= '</tbody>';
            }
        } else {
            $string.=$data;
        }

        if ($this->option('paginate') ) {
            $string .= '<tfoot>';
            $string.=$this->htmlPagination;
            $string .='</tfoot></table>';
        } else {
            $string .='</table>';
        }
        if ($return) {
            return $string;
        } else {
            echo $string;
            return "";
        }
    }

    private function getValue($value, $type, &$obj) {
        if ($type == self::FN) {
            $pos1 = strpos($value, '(');
            $pos2 = strpos($value, ')');
            $params = substr($value, $pos1 + 1, $pos2 - $pos1 - 1);
            $params = explode(',', $params);
            foreach ($params as $k => $v) {
                $params[$k] = PHPEL::read(trim($v), $obj);
            }
            $methodName = substr($value, 0, $pos1);
        } else {
            $value = PHPEL::read($value, $obj);
        }
        if ($value === null) {
            $value = '';
        }
        if ($type == self::BOOLEAN) {
            return $value == 1 ? 'Sim' : 'Não';
        } else if ($type == self::STRING) {
            return $value;
        } else if ($type == self::CURRENCY) {
            return 'R$ ' . number_format($value, 2, ',', '.');
        } else if ($type == self::IMAGE) {
            return '<img src="' . $value . '" />';
        } else if ($type == self::NUMERIC) {
            return number_format($value, 0, ',', '.');
        } else if ($type == self::FN) {
            return $this->callMethod($methodName, $params);
        }
        return $value;
    }

    private function callMethod($method, $args) {
        $ref = new ReflectionClass($this);
        $method = $ref->getMethod($method);
        return $method->invokeArgs($this, $args);
    }

    public function singleImage(WebImage $img = null) {
        if ($img != null) {
            return '<img src="' . URL_IMAGES . $img->getImage(1)->getLink() . '" />';
        }
        return '';
    }

    public function linkedImage(WebImage $img = null, $path = NULL, $value = NULL, $forceShowLink = TRUE) {
        if ($img != null) {
            return '<a href="' . $path . '/' . $value . '"><img src="' . URL_IMAGES . $img->getImage(0)->getLink() . '" /></a>';
        }
        if ($forceShowLink) {
            return '<a href="' . $path . '/' . $value . '"><img src="' . URL_IMAGES . 'withoutimage50.png" /></a>';
        }
        return '';
    }

}

?>
