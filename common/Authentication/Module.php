<?php

//filename : Authentication/Module.php

namespace Authentication;

use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $em = $e->getApplication()->getEventManager();
        $em->attach('route', array($this, 'checkAuthenticated'));
    }

    public function isOpenRequest(MvcEvent $e) {
        if ($e->getRouteMatch()->getParam('controller') == 'Authentication\Controller\AuthController') {
            return true;
        }

        return false;
    }

    public function checkAuthenticated(MvcEvent $e) {
        $sm = $e->getApplication()->getServiceManager();
        if (!$sm->get('AuthService')->getStorage()->getSessionManager()
                        ->getSaveHandler()
                        ->read($sm->get('AuthService')->getStorage()->getSessionId())) {
            if ($e->getRouteMatch()->getParam('controller') != 'Authentication\Controller\Auth') {
                $e->getRouteMatch()->setParam('controller', 'Authentication\Controller\Auth');
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }   

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

}
