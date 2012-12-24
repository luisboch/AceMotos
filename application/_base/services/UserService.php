<?php
import("model/UserDAO.php");
import("services/BasicService.php");
import("exceptions/ValidationException.php");
import("util/StringValidator.php");
/**
 * Description of UserService
 *
 * @author luis
 */
class UserService extends BasicService {

    function __construct() {
        parent::__construct(new UserDAO());
    }

    /**
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public function checkLogin($email, $password) {
        return $this->dao->checkLogin($email, $password);
    }
    
    /**
     *
     * @param Entity $entity
     * @throws ValidationException 
     */
    protected function validate(Entity &$entity){
        //validate fields
        $validationEx = new ValidationException();
        
        if($entity->getName() == ''){
            $validationEx->addError("Nome inválido", "name");
        }
//        if($entity->getUsername() == '' || 
//                !$this->dao->checkValidUserName($entity->getUsername())){
//            $validationEx->addError("Login inválido, ou já cadastrado",
//                    "name");
//        }
        
        if($entity->getGroup() == ''){
            $validationEx->addError("Selecione o grupo", "group");
        }
        
        if($entity->getEmail() == '' || 
                !StringValidator::checkEmail($entity->getEmail())){
            $validationEx->addError("Entre com um e-mail válido", 'email');
        }
        
        if($entity->getPassword() == '' || $entity->getPasswordConfirm() != $entity->getPassword()){
            $validationEx->addError("Entre com uma senha válida", "password");
            $validationEx->addError("", "passwordConfirm");
        }
        
        if(!$validationEx->isEmtpy()){
            throw $validationEx;
        }
        
    }
}

?>
