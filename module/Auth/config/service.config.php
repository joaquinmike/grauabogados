<?php
namespace Auth;

return array(
    'factories' => array(         
        'Model\AuthUsuario' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthUsuario($adapter, $sm);
        },
        'Model\AuthRol' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthRol($adapter, $sm);
        },
     ),
                
    'invokables' => array(
    ),
);