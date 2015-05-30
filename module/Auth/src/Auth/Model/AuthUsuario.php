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
    protected $_table = 'USUARIO';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'USUCOD';
    

    /**
     * Datos del usuario con login
     * @return type
     */
    public function getUsuarioLoginByUsId($usId){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
                ->columns(array('USUCOD','USUNOM','THEMA'))
                ->join(array('t2' => 'TIP_USU '), 't1.TIPCOD = t2.TIPCOD', array('TIPCOD','TIPNOM'))
                ->join(array('t3' => 'TIPOPERSONAL '), 't1.PERCOD = t3.PERCOD', array(''))
            ->where(array('t1.VIGENTE = ?' => \Auth\Entity\AuthTipoPersonal::ESTADO_ACTIVO))
            ->where(array('t1.USUCOD = ?' => $usId));
        echo $select->getSqlString();exit;
        return $this->fetchRow($select);
    }

}
