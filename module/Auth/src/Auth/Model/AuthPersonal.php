<?php

/**
 * Currency db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthPersonal extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_personal';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'pers_id';
    
    public function getPersonalAllByOrder($page, $filter = NULL, $limit = \Application\Entity\Functions::LIMIT_DEFAULT){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('pers_id', 'nombreper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(nombreper,1)),SUBSTR(lower(nombreper),2))'),
                 'apepatper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apepatper,1)),SUBSTR(lower(apepatper),2))'),
                'apematper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apematper,1)),SUBSTR(lower(apematper),2))'),
                'direccion','telefono','email'))
            ->join(array('t2' => 'auth_usuario'), 't1.pers_id = t2.pers_id', array('us_id'),'left');
        if(!empty($order)){
            $select->order($order);
        }
        if(!empty($filter)){
            if(!empty($filter['pers_tipo'])){
                $select->where(array('tipoper = ?' => $filter['pers_tipo']));
            }
            if(!empty($filter['pers_area'])){
                $select->where(array('area = ?' => $filter['pers_area']));
            }
            if(!empty($filter['pers_cargo'])){
                $select->where(array('cargo = ?' => $filter['pers_cargo']));
            }
            if(!empty($filter['pers_civil'])){
                $select->where(array('estcivil = ?' => $filter['pers_civil']));
            }
            if(!empty($filter['pers_sexo'])){
                $select->where(array('sexo = ?' => $filter['pers_sexo']));
            }
        }
        //echo $select->getSqlString();exit;
        $data = $this->getPaginatorForSelect($select, $page, $limit);
        return $data;
    }
    
}