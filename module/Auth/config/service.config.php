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
        'Model\AuthPersonal' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthPersonal($adapter, $sm);
        },
        'Model\AuthPrincipalPr' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthPrincipalPr($adapter, $sm);
        },
        'Entity\AuthPrincipalPr' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Entity\AuthPrincipalPr($adapter, $sm);
        },
     ),
                
    'invokables' => array(
    ),
);