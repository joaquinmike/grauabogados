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
    protected $_table = 'personal';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'percod';
    
    public function getPersonalAllByOrder($page, $filter = NULL, $search = NULL, $limit = \Application\Entity\Functions::LIMIT_DEFAULT){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('percod', 
                'nombreper' =>  new \Zend\Db\Sql\Expression("(case when len(rtrim(nombreper)) > 0 then UPPER(substring(nombreper,1,1)) + LOWER(SUBSTRING(nombreper,2,len(nombreper)-1)) else '.' end)"),
                'apepatper' =>  new \Zend\Db\Sql\Expression("(case when len(rtrim(apepatper)) > 0 then UPPER(substring(apepatper,1,1)) + LOWER(SUBSTRING(apepatper,2,len(apepatper)-1)) else '.' end)"),
                'apematper' =>  new \Zend\Db\Sql\Expression("(case when len(rtrim(apematper)) > 0 then UPPER(substring(apematper,1,1)) + LOWER(SUBSTRING(apematper,2,len(apematper)-1)) else '.' end)"),
                'codigo','direccion','telefono','email'))
            ->join(array('t2' => 'auth_usuario'), 't1.percod = t2.percod', array('us_id'),'left')
            ->join(array('t3' => 'tabla_se'), new \Zend\Db\Sql\Expression("t3.princod = '002' and t3.secucod = t1.tipoper"), 
                array('pert_id' => 'secucod','pert_nombre' => 'secudes'))
            ->where(array('tipoper not in (?,?,?)' => array('008','009','012')))
            ->order(array('tipoper','apepatper','apematper','nombreper'));
        if(!empty($filter['pers_estado'])){
            $select->where(array('estado = ?' => $filter['pers_estado']));
        }else{
            $select->where(array('estado = ?' => \Auth\Entity\AuthPersonal::ESTADO_ACTIVO));
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
        if(!empty($search)){
            $select->where->literal('(lower(apepatper) like ? or lower(apematper) like ? or lower(nombreper) like ? or lower(nomcomper) like ?)', 
                    array('%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%'));
        }
        //echo $select->getSqlString();exit;
        $data = $this->getPaginatorForSelect($select, $page, $limit);
        return $data;
    }
    
}