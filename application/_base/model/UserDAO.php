<?php

import('User.php');
import('lib/database.php');
import('model/BasicDAO.php');

/**
 * @author luis
 */
class UserDAO extends BasicDAO
{

    function __construct()
    {
        $this->setTableName(" `users` ");

    }

    /**
     *
     * @param string $string
     * @return array User
     */
    public function search($string)
    {

        $sql = "select " . $this->getFields() . ' from ' . $this->getTableName() .
            ' where email like ? or name like ? or username like ? ';

        $p = $this->getConnection()->prepare($sql);

        $p->setParameter(1, $string . '%', PreparedStatement::STRING);
        $p->setParameter(2, $string . '%', PreparedStatement::STRING);
        $p->setParameter(3, $string . '%', PreparedStatement::STRING);

        $rs = $p->execute();
        $users = array();

        while ($rs->next()) {
            $users[] = $this->getObject($rs);
        }

        return $users;
    }

    public function checkLogin($email, $passwd)
    {
        $sql = "select" . $this->getFields() . 'from ' . $this->getTableName() .
            ' where email = ? and password = ?';

        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $email, PreparedStatement::STRING);
        $p->setParameter(2, md5($passwd), PreparedStatement::STRING);
        $rs = $p->execute();

        if ($rs->getNumRows() != 1) {
            throw new NoResultException("Entity type:" .
                $this->getTableName() . ' not found');
        }

        $rs->next();

        return $this->getObject($rs);

    }

    protected function executeDelete(Entity &$entity)
    {
        throw new NotImplementedException();
    }

    protected function executeInsert(Entity &$entity)
    {
        $sql = "insert into " . $this->getTableName() . ' (name, email, cpf, `group`, `password`)
             values(?,?,?,?,?) ';
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getEmail(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getCpf(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getGroup(), PreparedStatement::INTEGER);
        $p->setParameter(5, md5($entity->getPassword()), PreparedStatement::STRING);

        $p->execute();

        $entity->setId($this->getConn()->lastId());

    }

    protected function executeUpdate(Entity &$entity)
    {

        $sql = "update " . $this->getTableName() . ' set name = ?, email = ?, cpf = ?, `group` = ?
            ' . ($entity->getPassword() == '' ? '' : ', `password`= ?') . ' where id = ? ';
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $entity->getName(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getEmail(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getCpf(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getGroup(), PreparedStatement::INTEGER);

        if ($entity->getPassword() != '') {
            $p->setParameter(5, md5($entity->getPassword()), PreparedStatement::STRING);
        }

        $p->setParameter(($entity->getPassword() == '' ? 5 : 6), $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();

    }

    public function getFields()
    {
        return ' `id`, `name`, `username`, `password`, `email`, `cpf`, `group` ';
    }

    public function getObject(ResultSet &$rs)
    {
        $arr = $rs->fetchArray();
        $ob = new User();
        $ob->setCpf($arr['cpf']);
        $ob->setEmail($arr['email']);
        $ob->setGroup($arr['group']);
        $ob->setId($arr['id']);
        $ob->setUsername($arr['username']);
        $ob->setName($arr['name']);
        return $ob;
    }

    public function checkValidUserName($username)
    {
        $sql = "select count(id) from user where username = ?";
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $username, PreparedStatement::STRING);
        $rs = $p->execute();

        if ($rs->getNumRows() != 0) {
            return false;
        }
        return true;

    }
}

?>
