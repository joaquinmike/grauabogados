<?php

/**
 * Currency db table AuthPrincipalPr
 *
 * @author joaquinmike <jmike410@gmail.com>
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthPrincipalPr extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'tabla_pr';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'princod';
    
    public function getDataFiltroByCode($code){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('princod'))
            ->join(array('t2' => 'tabla_se'), 't1.princod = t2.princod', 
                array('secucod','secudes' => new \Zend\Db\Sql\Expression("concat(SUBSTRING(secudes,1,27),(CASE WHEN LEN(secudes) > 26 THEN '...' ELSE '' END))")))
            ->where(array('t1.princod = ?' => $code))
            ->order(array('secucod'));
        return $this->fetchAll($select);
    }
}