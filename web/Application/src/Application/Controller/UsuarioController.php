<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Session\Container;
use Util\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class UsuarioController  extends BaseController {
    
    public function listaAction(){
        $page = $this->params()->fromQuery('page', 1); 
        $filtro = $this->params()->fromQuery('filtro', NULL);
        $buscador = $this->params()->fromQuery('perssearch', NULL);
        $post = array();
        $formFilter = $this->getServiceLocator()->get('Form\FormUsuarioFiltro');
        $sesPersonal = new Container('personal');
        if($this->getRequest()->isPost()){
            $post = $this->params()->fromPost();
            $sesPersonal->filter =  $post;
        }
        if(empty($sesPersonal->filter)){
            $sesPersonal->filter = array();
        }else{
            $formFilter->setData($sesPersonal->filter);
        }
        
        if(empty($sesPersonal->search)){
            $sesPersonal->search = NULL;
        }
        if(!is_null($buscador)){
             $sesPersonal->search = $buscador;
        }
        
        $item = 1;
        if($page > 1){
            $item = (($page - 1) * \Application\Entity\Functions::LIMIT_DEFAULT) + 1;
        }
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $paginator = $modelPersonal->getPersonalAllByOrder($page,$sesPersonal->filter,$sesPersonal->search);
        $data = \Auth\Entity\AuthPersonal::formatGrupoPersonalByPaginator($paginator);
        return new ViewModel(array(
            'item' => $item,
            'formFilter' => $formFilter,
            'paginator' => $paginator,
            'data' => $data,
            'buscador' => $sesPersonal->search
        ));
    }
    
    public function listaLimpiarAction(){
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $json = new JsonModel( array('success' => 1) );
        return $json;
        
    }
}
