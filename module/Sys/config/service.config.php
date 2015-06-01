<?php
namespace Sys;

return array(    
   'factories' => array(
        'Model\SysRecurso' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Sys\Model\SysRecurso($adapter, $sm);
        },
    ),
    'invokables' => array(
    ),
);