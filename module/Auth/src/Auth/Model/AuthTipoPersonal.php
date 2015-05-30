<?php

/**
 * AuthTipoPersonal db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthTipoPersonal extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'TIPOPERSONAL';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary =  array('PERCOD','TIPOPER','FECINI');
    
}
