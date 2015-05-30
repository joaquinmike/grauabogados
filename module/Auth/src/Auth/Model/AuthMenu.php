<?php

/**
 * AuthMenu db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthMenu extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'MENUU';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary =  array('EMPCOD','LOCCOD','MENUCOD','SISCOD');
    
}
