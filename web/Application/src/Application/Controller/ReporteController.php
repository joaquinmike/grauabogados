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

class ReporteController  extends BaseController {
    
    public function diagramaAction(){
        $tipo     = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site     = $this->params()->fromQuery('site', NULL); 
        $nom = $this->params()->fromQuery('nom', NULL);
        
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '06';
        $fechaFin = $date->format('Y') . '06';
        //$fechaIni = $date->format('Ym');
        //$fechaFin = $date->format('Ym');
        $nombre = \Application\Entity\Functions::getNombreMesByMesId($date->format('m')) . ' ' . $date->format('Y');
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $data = $modelPersonal->getGraficoPersonalByCategoria($persCode,$fechaIni,$fechaFin);
        
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'data' => $data,
            'nombre' => $nombre,
            'codigo' => $persCode,
            'abogado'=> $nom,
        ));
    }
    
    public function personalAction(){
        $tipo = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        $nom = $this->params()->fromQuery('nom', NULL); 
       
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $personal = $modelPersonal->getDataPersonalByPersCodigo($persCode);
        $dtaPersonal = $modelPersonal->getListaPersonalByArId($personal['area']);
        //$data = $modelPersonal->getGraficoPersonalByCliente($persCode,$fechaIni,$fechaFin);
        
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
            'tipo' => $tipo,
            'site' => $site,
            'data' => $data,
            'nombre' => $nombre,
            'codigo' => $persCode,
            'abogado'=> $nom,
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
