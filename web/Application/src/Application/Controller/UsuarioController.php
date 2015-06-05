<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Util\Controller\BaseController;
use Zend\View\Model\ViewModel;

class UsuarioController  extends BaseController {
    
    public function listaAction(){
        $page = $this->params()->fromQuery('page', 1); 
        $item = 1;
        if($page > 1){
            $item = (($page - 1) * \Application\Entity\Functions::LIMIT_DEFAULT) + 1;
        }
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $paginator = $modelPersonal->getPersonalAllByOrder($page);
       
        return new ViewModel(array(
            'item' => $item,
            'paginator' => $paginator
        ));
    }
}
