<?php
import('model/ClientDAO.php');
import('services/BasicService.php');
import('util/TimeZoneUtil.php');
import('util/StringValidator.php');
/**
 * Description of ClientService
 *
 * @author Luis
 */
class ClientService extends BasicService{
    public function __construct() {
        parent::__construct(new ClientDAO());
    }
    protected function validate(\Entity &$entity) {
        
        $v = new ValidationException();
        if($entity->getName() == ""){
            $v->addError("Preencha o nome corretamente!", "name");
        }
        if($entity->getEmail() == "" ||
            !StringValidator::checkEmail($entity->getEmail())){
            $v->addError("Preencha o email corretamente!", "email");
        }
        
        if($entity->getCountryCode() == ""){
            if($entity->getType() == 'F'){
                $v->addError("Preencha o cpf corretamente!", "countryCode");
            } else {
                $v->addError("Preencha o cnpj corretamente!", "countryCode");
            }
        }
        
        if($entity->getTimeZone() == ""){
            $v->addError("Selecione o TimeZone!", "timeZone");
        }
        if(!$v->isEmtpy()){
            throw $v;
        }
    }
    protected function validateNews(Client &$entity) {
        
        $v = new ValidationException();
        if($entity->getName() == ""){
            $v->addError("Preencha o nome corretamente!", "name");
        }
        if($entity->getEmail() == "" ||
            !StringValidator::checkEmail($entity->getEmail())){
            $v->addError("Preencha o email corretamente!", "email");
        }
        
        if(!$v->isEmtpy()){
            throw $v;
        }
    }
    
    /**
     *
     * @param Client $client
     * @throws ValidationException
     * @return void
     */
    public function saveNewsLetter(Client &$client){
         $this->validateNews($client);
        $this->dao->begin();
        $this->dao->save($client, false);
        $this->dao->commit();
    }
}

?>
