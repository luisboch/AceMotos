<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
import('interfaces/Entity.php');
/**
 * Description of User
 *
 * @author luis
 */
class User implements Entity
{

    /**
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $username;
    /**
     *
     * @var passwd
     */
    private $password;

    /**
     * este atributo é usado somente e unicamente para
     * confirmação da senha do usuário no cadastro.
     * @var string
     * @Transient
     */
    private $passwordConfirm;
    /**
     * @var string
     */
    private $email;

    /**
     * @var string;
     */
    private $cpf;

    /**
     *
     * @var int
     */
    private $group;

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @return integer
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     *
     * @param integer $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     *
     * @return string
     */
    public function getPasswordConfirm()
    {
        return $this->passwordConfirm;
    }

    /**
     *
     * @param string $passwordConfirm
     */
    public function setPasswordConfirm($passwordConfirm)
    {
        $this->passwordConfirm = $passwordConfirm;
    }


}

?>
