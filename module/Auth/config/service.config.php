<?php
namespace Auth;

return array(
    'factories' => array(         
               
        'Model\AuthUsuario' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthUsuario($adapter, $sm);
        },
        'Model\AuthMenu' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthMenu($adapter, $sm);
        },
        'Model\AuthUsuarioMenu' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthUsuarioMenu($adapter, $sm);
        },
        'Model\AuthTipoPersonal' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new \Auth\Model\AuthTipoPersonal($adapter, $sm);
        },
     ),
                
    'invokables' => array(
    ),
);