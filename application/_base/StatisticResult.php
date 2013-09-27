<?php

/**
 * Description of StatisticResult
 *
 * @author Luis
 */
class StatisticResult {

    private $qtdLastWeek;
    private $qtdThisWeek;
    private $qtdYesterday;
    private $qtdToday;
    private $prdTen = array();
    private $catTen = array();

    public function getQtdLastWeek() {
        return $this->qtdLastWeek;
    }

    public function setQtdLastWeek($qtdLastWeek) {
        $this->qtdLastWeek = $qtdLastWeek;
    }

    public function getQtdThisWeek() {
        return $this->qtdThisWeek;
    }

    public function setQtdThisWeek($qtdThisWeek) {
        $this->qtdThisWeek = $qtdThisWeek;
    }

    public function getQtdYesterday() {
        return $this->qtdYesterday;
    }

    public function setQtdYesterday($qtdYesterday) {
        $this->qtdYesterday = $qtdYesterday;
    }
    
    public function getQtdToday() {
        return $this->qtdToday;
    }

    public function setQtdToday($qtdToday) {
        $this->qtdToday = $qtdToday;
    }
    
    /**
     * 
     * @return PrdtStatistc[]
     */
    public function getPrdTen() {
        return $this->prdTen;
    }

    public function setPrdTen($prdTen) {
        $this->prdTen = $prdTen;
    }

    /**
     * 
     * @return CatStatistc[]
     */
    public function getCatTen() {
        return $this->catTen;
    }

    public function setCatTen($catTen) {
        $this->catTen = $catTen;
    }

}

class PrdtStatistc {

    private $productId;
    private $productName;
    private $qtd;

    public function getProductId() {
        return $this->productId;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function setQtd($qtd) {
        $this->qtd = $qtd;
    }

}

class CatStatistc {

    private $catId;
    private $catName;
    private $qtd;

    public function getCatId() {
        return $this->catId;
    }

    public function setCatId($catId) {
        $this->catId = $catId;
    }

    public function getCatName() {
        return $this->catName;
    }

    public function setCatName($catName) {
        $this->catName = $catName;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function setQtd($qtd) {
        $this->qtd = $qtd;
    }

}
?>
