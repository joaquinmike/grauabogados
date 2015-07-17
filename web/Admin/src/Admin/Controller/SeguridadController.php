<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Util\Controller\BaseController;
use Zend\View\Model\ViewModel;

class SeguridadController extends BaseController {
    
    public function usuarioListaAction()
    {
        
        return new ViewModel();
    }
    
    public function usuarioFormAction()
    {
        $form = $this->getServiceLocator()->get('Form\FormRegistroUsuario');
        return new ViewModel(array(
            'form' => $form,
        ));
    }
}
