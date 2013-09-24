<?php

import("model/StatisticDAO.php");
import('services/BasicService.php');

/**
 * Description of StatisticService
 *
 * @author Luis
 */
class StatisticService extends BasicService{
    private $statistcDAO;
    
    function __construct() {
        parent::__construct(new StatisticDAO());
        $this->statistcDAO = $this->dao;
    }
    
    public function saveStatistc($page, $itemId, $observation) {
        
        $entity = new Statistic();
        
        $entity->setItem_id($itemId);
        $entity->setObservation($observation);
        $entity->setPage($page);
        
        parent::save($entity);
    }
    
}

?>
