<?php

/**
 * Currency db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthUsuario extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_usuario';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'us_id';
    

    /**
     * Datos del usuario con login
     * @return type
     */
    public function getUsuarioLoginByUsId($usId){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
                ->columns(array('us_id','us_nombre','us_apellidos','us_usuario'))
                ->join(array('t2' => 'auth_rol'), 't1.rol_id = t2.rol_id', array('rol_id','rol_desc'))
                ->join(array('t3' => 'auth_personal'), 't1.pers_id = t3.pers_id', array('percod'))
            ->where(array('t1.us_estado = ?' => 1))
            ->where(array('t1.us_id = ?' => $usId));
        //echo $select->getSqlString();exit;
        return $this->fetchRow($select);
    }

}
