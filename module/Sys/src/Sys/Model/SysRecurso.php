<?php

/**
 * AuthRecurso db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Sys\Model;

use Util\Model\Repository\Base\AbstractRepository;

class SysRecurso extends AbstractRepository {
    /**
     * @var String Name of db table
     */
    protected $_table = 'sys_recurso';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary =  'recurso_id';
    
    
    public function getMenuRolByRolId($rolId){
        $cache = $this->getServiceLocator()->get('Cache');
        $key    = $this->_table . '_' . md5($rolId);
        $result = $cache->getItem($key, $success);
        if(!$success){
            $select = $this->sql->select()->from(array('t1' => $this->_table))
               ->columns(array('recurso_id','recurso_desc','recurso_uri','rec_recurso_id'))
               ->join(array('t2' => 'sys_rol_recurso'), 't1.recurso_id = t2.recurso_id', array('rolrec_permiso'))
               ->where(array('t1.recurso_estado = ?' => \Application\Entity\Functions::ESTADO_ACTIVO))
               ->where(array('t1.recurso_tipo = ?' => \Sys\Entity\SysRecurso::TIPO_MENU))
               ->where(array('t2.rolrec_permiso = ?' => \Sys\Entity\SysRecurso::ESTADO_PERMISO))
               ->where(array('t2.rol_id = ?' => $rolId))
               ->order(array('rec_recurso_id','recurso_orden'));
           //echo $select->getSqlString();exit;
           $data = $this->fetchAll($select);
           $result = \Sys\Entity\SysRecurso::getConvertRecursoToMenu($data);
           $cache->setItem($key, $result);
        }
        return $result;
    }
}
