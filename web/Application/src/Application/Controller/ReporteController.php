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
use Zend\View\Model\JsonModel;

class ReporteController  extends BaseController {
    
    public function diagramaAction(){
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '05';
        $nombre = \Application\Entity\Functions::getNombreMesByMesId($date->format('m')) . ' ' . $date->format('Y');
        $tipo = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'nombre' => $nombre,
            'codigo' => $persCode,
            
        ));
    }
    
    public function personalAction(){
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '05';
        $nombre = \Application\Entity\Functions::getNombreMesByMesId($date->format('m')) . ' ' . $date->format('Y');
        $tipo = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $formFilter = $this->getServiceLocator()->get('Form\FormReportePersonal');
        $modelPersonal = $this->getServiceLocator()->get('Model\auth_personal');
        $personal = $modelPersonal->getDataPersonalByPersCodigo($persCode);
        $dtaPersonal = $modelPersonal->getListaPersonalByArId($personal['area']);
        $formFilter->setData(array(
            'anio_start' => date('Y'),
            'anio_end' => date('Y'),
            'mes_start' => date('m'),
            'mes_end' => date('m'),
            'date_start' => date('d/m/Y'),
            'date_end' => date('d/m/Y'),
            'pers_area' => $personal['area']
        ));
        return new ViewModel(array(
            'formFilter' => $formFilter,
            'tipo' => $tipo,
            'site' => $site,
            'nombre' => $nombre,
            'personal' => $personal,
            'lista' => $dtaPersonal,
        ));
    }
    
    public function personalListaAction(){
        $post = $this->params()->fromPost();
        $modelPersonal = $this->getServiceLocator()->get('Model\auth_personal');
        $personal = $modelPersonal->getListaPersonalByArId($post['id']);
        if(!empty($personal)){
            $result = array('success' => 1, 'data' => $personal);
        }else{
            $result = array('success' => 0, 'data' => NULL);
        }
        $json = new JsonModel($result);
        return $json;
    }
    
    public function personalGraficoAction(){
        $post = $this->params()->fromPost();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables(
            array(
                'tipo' => $post['form_tipo'],
                'post' => $post,
            ))
            ->setTerminal(true);
        
        return $viewModel;
    }
    
}
