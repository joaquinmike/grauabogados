<?php
namespace Application;
use Util\Storage\DBStorage;
use Auth\Plugin\UserAuthentication;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;

use Auth\Model;

return array(    
   'factories' => array(
       'SessionDbStorage' => function ($serviceManager) {
            $config = $serviceManager->get('Config');
            return new DBStorage($serviceManager->get('Zend\Db\Adapter\Adapter')
                    , $config['session']['sessionConfig']);
        },
       'UserAuthentication' => function ($serviceManager) {
            $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
            $dbAuthAdapter = new DbAuthAdapter($adapter, 'auth_users', 'username', 'password', 'MD5(?)');
            $auth = new AuthenticationService();
            $auth->setAdapter($dbAuthAdapter);
            $UserAutentication = new UserAuthentication();
            $UserAutentication->setAuthAdapter($dbAuthAdapter);
            $UserAutentication->setAuthService($auth);
            return $UserAutentication;
        },
       'Model\AuthRoles' => function($serviceManager){
            return new Model\AuthRoles(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\AuthRecursos' => function($serviceManager){
            return new Model\AuthRecursos(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\AuthRolesRecursos' => function($serviceManager){
            return new Model\AuthRolesRecursos(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\PgpTiposSuscripcion' => function($serviceManager){
                return new \Pgp\Model\PgpTiposSuscripcion(
                        $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                        $serviceManager
                    );
            },
        'Model\PgpPago' => function($serviceManager){
            return new \Pgp\Model\PgpPago(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\PgpPerfilPago' => function($serviceManager){
            return new \Pgp\Model\PgpPerfilPago(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\SysCountry' => function($serviceManager){
            return new \Sys\Model\SysCountry(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Model\PgpOperaciones' => function($serviceManager){
            return new \Pgp\Model\PgpOperaciones(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager);
        },
        'Model\AuthUsers' => function($serviceManager){
            return new \Auth\Model\AuthUsers(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'Form\FormPago' => function($serviceManager){
            return new \Pgp\Form\FormPago($serviceManager);
        },     
        'Model\EduProductos' => function($serviceManager){
            return new \Edu\Model\EduProductos(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
       
        'Model\SysPartners' => function($serviceManager){
            return new \Sys\Model\SysPartners(
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
        'PaymentCart' => function($serviceManager) {
            $config = $serviceManager->get('Config');
            return new \Payment\Model\PaymentCart($config['zendcart']);
        },
    ),
);