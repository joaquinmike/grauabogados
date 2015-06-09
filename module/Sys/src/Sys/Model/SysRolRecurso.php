<?php

/**
 * Description of SysRolRecurso
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Sys\Model;

use Util\Model\Repository\Base\AbstractRepository;

class SysRolRecurso extends AbstractRepository {
    /**
     * @var String Name of db table
     */
    protected $_table = 'sys_rol_recurso';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary =  array('rol_id','recurso_id');
    
    public function getPermissions()
    {
        return $this->getAllRolPermissions();
    }
    
    public function getAllRolPermissions() 
    {
       $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('rolrec_permiso','rol_id'))
            ->join(array('t2' => 'sys_recurso'), 't1.recurso_id = t2.recurso_id',array('recurso_id','recurso_uri'));
        $recursos =  $this->fetchAll($select);
        $response = array();
        if (!empty($recursos)) {
            foreach ($recursos as $value) {
                $response[$value['rol_id']][$value['recurso_id']] = array(
                    'recurso_id' => $value['recurso_id'],
                    'recurso_uri' => $value['recurso_uri'],
                    'rol_permiso' => $value['rolrec_permiso']
                );
            }
        }
        return $response;
    }
}