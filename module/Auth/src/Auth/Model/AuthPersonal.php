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
                'nombreper' =>  new \Zend\Db\Sql\Expression("dbo.WordCap(nombreper)"),
                'apepatper' =>  new \Zend\Db\Sql\Expression("dbo.WordCap(apepatper)"),
                'apematper' =>  new \Zend\Db\Sql\Expression("dbo.WordCap(apematper)"),
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
    
    public function getGraficoPersonalByCliente($perCod){
        $select = $this->sql->select()->from(array('t1' => 'v_grafico_horas_x_cliente'),
               array('cliente','tiempo' => 'sum(tiemponum) '))
           ->where(array('percod => ?' => $perCod))
           ->group(array('cliente'));
         return $this->fetchAll($select);
    }
    
     public function getGraficoPersonalByCategoria($areaCode){
        $select = $this->sql->select()->from(array('t1' => 'v_grafico_horas_x_cliente'),
               array('cliente','tiempo' => 'sum(tiemponum) '))
           ->where(array('areacod  => ?' => $areaCode))
           ->group(array('cliente'))
            ->order('cliente');
         return $this->fetchAll($select);
    }
    
}