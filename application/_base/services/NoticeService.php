<?php

import('model/NoticeDAO.php');
import('services/BasicService.php');
import('exceptions/ValidationException.php');


/**
 *
 * @author felipe
 * @since Jul 22, 2012
 */
class NoticeService extends BasicService
{
    //put your code here

    function __construct()
    {

        parent:: __construct(new NoticeDAO());

    }

    protected function validate(Entity &$entity)
    {

        $ve = new ValidationException();

        if ($entity->getTitle() == '') {
            $ve->addError('Por Favor Preencha o titulo corretamente', 'title');
        }

        if ($entity->getResume() == '') {
            $ve->addError('Por Favor Preencha o resumo corretamente', 'resume');
        }

        if ($entity->getNotice() == '') {
            $ve->addError('Por Favor Preencha a noticia corretamente', 'notice');
        }

        if (!$ve->isEmtpy()) {
            throw $ve;
        }
    }

}

?>
