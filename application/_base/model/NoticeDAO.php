<?php

import('Notice.php');
import('WebImage.php');
import('model/BasicDAO.php');

/**
 *
 * @author felipe
 * @since Jul 22, 2012
 */
class NoticeDAO extends BasicDAO
{

    function __construct()
    {
        $this->setTableName(" `notices` ");
    }

    protected function executeDelete(Entity &$entity)
    {

        $sql = "delete from " . $this->getTableName() . " where id = ?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
    }

    protected function executeInsert(Entity &$entity)
    {

        $sql = "insert into " . $this->getTableName() . "(" . $this->getFields() . ") values (?,?,?,?)";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->setParameter(2, $entity->getTitle(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getResume(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getNotice(), PreparedStatement::STRING);
        $p->execute();
        $entity->setId($this->getConn()->lastId());
        $this->saveImages($entity);
    }

    private function saveImages(Notice &$entity)
    {
        $webImage = $entity->getWebImage();
        if ($webImage != '') {
            $images = $webImage->getImages();
            foreach ($images as $k => $ob) {
                $sql = "insert 
                          into fotos_noticia (link, tamanho, noticia_id)
                               values(? , ?, ?)";
                $p = $this->getConn()->prepare($sql);
                $p->setParameter(1, $ob->getLink(), PreparedStatement::STRING);
                $p->setParameter(2, $k, PreparedStatement::INTEGER);
                $p->setParameter(3, $entity->getId(), PreparedStatement::INTEGER);
                $p->execute();
            }
        }
    }

    protected function executeUpdate(Entity &$entity)
    {
        $sql = "UPDATE " . $this->getTableName() . " 
                    SET `titulo`=?,
                        `resumo`=?,
                        `noticia`=? 
                    WHERE id=?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getTitle(), PreparedStatement::STRING);
        $p->setParameter(2, $entity->getResume(), PreparedStatement::STRING);
        $p->setParameter(3, $entity->getNotice(), PreparedStatement::STRING);
        $p->setParameter(4, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();

        // Remove all images
        $sql = "delete from fotos_noticia where noticia_id = ?";
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $entity->getId(), PreparedStatement::INTEGER);
        $p->execute();
        $this->saveImages($entity);
    }

    public function getFields()
    {
        return ' `id`, `titulo`, `resumo`, `noticia` ';
    }

    /**
     *
     * @param ResultSet $rs
     * @return Notice
     */
    public function getObject(ResultSet &$rs)
    {
        return $this->getObjectWithOption($rs);
    }

    /**
     *
     * @param ResultSet $rs
     * @return Notice
     */
    public function getObjectWithOption(ResultSet &$rs, $fullObject = true)
    {

        $arr = $rs->fetchArray();

        $notice = new Notice();
        $notice->setId($arr['id']);
        $notice->setTitle($arr['titulo']);
        $notice->setResume($arr['resumo']);
        $notice->setNotice($arr['noticia']);
        if ($fullObject) {
            $sql = "select id, link, tamanho from fotos_noticia where noticia_id = ? order by tamanho";
            $p = $this->getConn()->prepare($sql);

            $p->setParameter(1, $arr['id'], PreparedStatement::INTEGER);
            $rs1 = $p->execute();
            if ($rs1->getNumRows() > 0) {
                $webImage = new WebImage();
                while ($rs1->next()) {
                    $fotArr = $rs1->fetchArray();
                    $img = new Image($fotArr['link']);
                    $webImage->setImage($img, $fotArr['tamanho']);
                }
                $notice->setWebImage($webImage);
            }
        }
        return $notice;
    }

    public function search($string)
    {
        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
            . ' where id = ? or titulo like ? or resumo like ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string, PreparedStatement::STRING);
        $p->setParameter(3, $string, PreparedStatement::STRING);
        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $arr[] = & $this->getObjectWithOption($rs, true);
        }

        return $arr;
    }

    public function count($string)
    {
        $sql = 'select count(*) as qtd from ' . $this->getTableName()
            . ' where id = ? or titulo like ? or resumo like ?';
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string, PreparedStatement::STRING);
        $p->setParameter(3, $string, PreparedStatement::STRING);
        $rs = $p->execute();
        $rs->next();
        $arr = $rs->fetchAssoc();
        return $arr[0];
    }

    public function paginationSearch($string, $start = NULL, $limit = NULL)
    {

        if ($start === NULL || $limit === NULL) {
            return $this->search($string);
        }

        $sql = 'select ' . $this->getFields() . ' from ' . $this->getTableName()
            . ' where id = ? or titulo like ? or resumo like ? LIMIT ' . $start . ', ' . $limit;
        $p = $this->getConn()->prepare($sql);
        $p->setParameter(1, $string, PreparedStatement::INTEGER);
        $p->setParameter(2, $string, PreparedStatement::STRING);
        $p->setParameter(3, $string, PreparedStatement::STRING);
        $rs = $p->execute();
        $arr = array();

        while ($rs->next()) {
            $arr[] = & $this->getObjectWithOption($rs, true);
        }
        return $arr;
    }

}

?>
