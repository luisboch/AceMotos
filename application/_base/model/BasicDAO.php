<?php
import("lib/database.php");
import("interfaces/EntityDAO.php");
import('exceptions/NotImplementedException.php');
import('exceptions/NoResultException.php');
/**
 * @author luis.boch [luis.boch@gmail.com]
 */
abstract class BasicDAO implements EntityDAO
{

    /**
     *
     * @var Connection
     */
    private $conn;

    /**
     *
     * @return Connection
     */

    private $tableName;

    /**
     *
     * @return Connection
     */
    protected function getConnection()
    {
        return $this->conn === NULL ? ($this->conn = & Connection::getConnection()) : $this->conn;
    }

    protected abstract function executeInsert(Entity &$entity);

    protected abstract function executeUpdate(Entity &$entity);

    protected abstract function executeDelete(Entity &$entity);

    public function delete(Entity &$entity, $autocommit = true)
    {
        if (!$autocommit) {
            $this->conn->autoCommit(false);
        }
        $this->executeDelete($entity);
        if ($autocommit) {
            $this->conn->commit();
            $this->conn->autoCommit();
        }
    }

    public function save(Entity &$entity, $autocommit = true)
    {
        if (!$autocommit) {
            $this->conn->autoCommit(false);
        }
        $this->executeInsert($entity);
        if ($autocommit) {
            $this->conn->commit();
            $this->conn->autoCommit();
        }
    }

    public function update(Entity &$entity, $autocommit = true)
    {
        if (!$autocommit) {
            $this->conn->autoCommit(false);
        }
        $this->executeUpdate($entity);
        if ($autocommit) {
            $this->conn->commit();
            $this->conn->autoCommit();
        }
    }

    /**
     *
     * @param integer $id
     * @return Entity
     * @throws NoResultException
     */
    public function getById($id)
    {
        $sql = "select " . $this->getFields() . ' from ' . $this->getTableName() .
            " where id = ?";
        $p = $this->getConnection()->prepare($sql);
        $p->setParameter(1, $id, PreparedStatement::INTEGER);
        $rs = $p->execute();
        if ($rs->getNumRows() != 1) {
            throw new NoResultException("Entity table:" . $this->tableName . ' not found with id:' . $id);
        }
        $rs->next();
        return $this->getObject($rs);
    }

    protected function getTableName()
    {

        if ($this->tableName == "") {
            throw new InvalidArgumentException('Table name must be set, you can use
                $this->setTableName(tableName) to set.');
        }

        return $this->tableName;
    }

    protected function setTableName($className)
    {
        $this->tableName = $className;
    }

    /**
     *
     * @return Connection
     */
    public function getConn()
    {
        return $this->conn === NULL ? ($this->conn = & Connection::getConnection()) : $this->conn;
    }

    public function begin()
    {
        return $this->getConn()->begin();
    }

    public function commit()
    {
        return $this->getConn()->commit();
    }

    public function rollback()
    {
        return $this->getConn()->rollback();
    }

    /**
     *
     * @param string $string
     * @throws NotImplementedException
     */
    public function count($string)
    {
        throw new NotImplementedException("Method " . __METHOD__ . ' is not implemented!');
    }

    /**
     * @param string $string
     * @param int $start
     * @param int $limit
     * @throws NotImplementedException
     */
    public function paginationSearch($string, $start = NULL, $limit = NULL)
    {
        throw new NotImplementedException("Method " . __METHOD__ . ' is not implemented!');
    }

}

?>
