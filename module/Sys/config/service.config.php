<?php
namespace Sys;

return array(    
   'factories' => array(
        'Model\SysRecurso' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Sys\Model\SysRecurso($adapter, $sm);
        },
        'Model\SysRolRecurso' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Sys\Model\SysRolRecurso($adapter, $sm);
        },
    ),
    'invokables' => array(
    ),
);