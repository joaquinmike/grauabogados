<?php

/**
 * AuthUsuarioMenu db table
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthUsuarioMenu extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'USU_MENU';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary =  array('MENUCOD','USUCOD','SISCOD');
    
    public function getMenuUSuarioByUsId($usId){
        
    }
    
}
