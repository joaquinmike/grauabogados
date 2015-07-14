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

    public function getPersonalAllByOrder($page, $filter = NULL, $search = NULL, $limit = \Application\Entity\Functions::LIMIT_DEFAULT) {
        $select = $this->sql->select()->from(array('t1' => $this->_table))
                ->columns(array('percod','area',
                    'nombreper' => new \Zend\Db\Sql\Expression("dbo.WordCap(Lower(nombreper))"),
                    'apepatper' => new \Zend\Db\Sql\Expression("dbo.WordCap(Lower(apepatper))"),
                    'apematper' => new \Zend\Db\Sql\Expression("dbo.WordCap(Lower(apematper))"),
                    'codigo', 'direccion', 'telefono', 'email', 'celular1', 'anexo','tipoper',
                    'nomcomper' => new \Zend\Db\Sql\Expression("dbo.wordCap(Lower(nomcomper))")))
                //->join(array('t2' => 'auth_usuario'), 't1.percod = t2.percod', array('us_id'), 'left')
                ->join(array('t3' => 'tabla_se'), new \Zend\Db\Sql\Expression("t3.princod = '002' and t3.secucod = t1.tipoper"), array('pert_id' => 'secucod', 'pert_nombre' => 'secudes'))
                ->where(array('tipoper in (?,?,?,?,?)' => array('001', '002', '005', '006', '007')))
                ->order(array('tipoper', 'nomcomper'));
        if (!empty($filter['pers_estado'])) {
            $select->where(array('estado = ?' => $filter['pers_estado']));
        } else {
            $select->where(array('estado = ?' => \Auth\Entity\AuthPersonal::ESTADO_ACTIVO));
        }
        if (!empty($filter)) {
            if (!empty($filter['pers_tipo'])) {
                $select->where(array('tipoper = ?' => $filter['pers_tipo']));
            }
            if (!empty($filter['pers_area'])) {
                $select->where(array('area = ?' => $filter['pers_area']));
            }
            if (!empty($filter['pers_cargo'])) {
                $select->where(array('cargo = ?' => $filter['pers_cargo']));
            }
            if (!empty($filter['pers_civil'])) {
                $select->where(array('estcivil = ?' => $filter['pers_civil']));
            }
            if (!empty($filter['pers_sexo'])) {
                $select->where(array('sexo = ?' => $filter['pers_sexo']));
            }
        }
        if (!empty($search)) {
            $select->where->literal('(lower(apepatper) like ? or lower(apematper) like ? or lower(nombreper) like ? or lower(nomcomper) like ?)', array('%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%'));
        }
        //echo $select->getSqlString();exit;
        $data = $this->getPaginatorForSelect($select, $page, $limit);
        return $data;
    }
    

    public function getGraficoPersonalByCliente($perCod, $fechaIni, $fechaFin) {
        $select = $this->sql->select()->from(array('t1' => 'v_grafico_horas_x_area_anomes'))
                ->columns(array('cliente',
                                'tiempo' => new \Zend\Db\Sql\Expression('sum(horas)')                    
                    ))
                ->where(array('abogado = ?' => $perCod))
                ->where(array('anomes BETWEEN ? and ?' => array($fechaIni, $fechaFin)))
                ->group(array('cliente'))                
                ->quantifier('top 8')
                ->order(array('tiempo desc')); 
        //echo 'Personal <br>'.$select->getSqlString();exit;
        return $this->fetchAll($select);
    }

    public function getGraficoPersonalByCategoria($areaCode, $fechaIni, $fechaFin) {       
        $select = $this->sql->select()->from(array('t1' => 'v_grafico_horas_x_area_anomes'))                
                ->columns(array('areades','cliente',                                
                                'tiempo' => new \Zend\Db\Sql\Expression('sum(horas)')))
                ->where(array('area  = ?' => $areaCode))
                ->where(array('anomes BETWEEN ? and ?' => array($fechaIni, $fechaFin)))
                ->group(array('areades','cliente'))
                ->quantifier('top 8')                
                ->order(array('tiempo desc'));        
        //echo 'Área: <br>'.$select->getSqlString();exit;
        return $this->fetchAll($select);
    }
    
    public function getGraficoByabogado($cliente, $fechaIni, $fechaFin) {       
        $select = $this->sql->select()->from(array('t1' => 'v_grafico_horas_x_area_anomes'))                
                ->columns(array('usucod',                                
                                'tiempo' => new \Zend\Db\Sql\Expression('sum(horas)')))
                ->where(array('cliente  = ?' => $cliente))
                ->where(array('anomes BETWEEN ? and ?' => array($fechaIni, $fechaFin)))
                ->group(array('usucod'))
                ->order(array('tiempo desc'));        
        //echo 'Abogados: <br>'.$select->getSqlString();exit;
        return $this->fetchAll($select);
    }
    
    /**
     * Retorna los datos generales de un personal
     * @param type $persCodigo
     * @return type
     */
    public function getDataPersonalByPersCodigo($persCodigo){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('percod', 'nombreper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(nombreper,1)),SUBSTR(lower(nombreper),2))'),
                'apepatper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apepatper,1)),SUBSTR(lower(apepatper),2))'),
                'apematper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apematper,1)),SUBSTR(lower(apematper),2))'),
                'codigo','direccion','telefono','email','area'))
            ->join(array('t2' => 'auth_usuario'), 't1.pers_id = t2.pers_id', array('us_id'),'left')
            ->join(array('t3' => 'auth_tabla_se'), new \Zend\Db\Sql\Expression("t3.princod = '002' and t3.secucod = t1.tipoper"), 
                array('pert_id' => 'secucod','pert_nombre' => 'secudes'))
            ->where(array('t1.percod = ?' => $persCodigo))
            ->order(array('apepatper','apematper','nombreper'));
        return $this->fetchRow($select);
    }
    
    /**
     * Retorna toda la lista de personal pertenecientes a un área
     * @param type $arId
     * @return type
     */
    public function getListaPersonalByArId($arId){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('percod', 'nombreper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(nombreper,1)),SUBSTR(lower(nombreper),2))'),
                'apepatper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apepatper,1)),SUBSTR(lower(apepatper),2))'),
                'apematper' =>  new \Zend\Db\Sql\Expression('CONCAT(UPPER(LEFT(apematper,1)),SUBSTR(lower(apematper),2))'),
                'codigo','direccion','telefono','email','area'))
            ->order(array('apepatper','apematper','nombreper'));
        if(!empty($arId)){
            $select->where(array('t1.area = ?' => $arId));
        }
        return $this->fetchAll($select);
    }

}
