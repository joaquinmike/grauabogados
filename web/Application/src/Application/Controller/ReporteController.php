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
        $tipo = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '05';
        $fechaFin = $date->format('Ym');
        $nombre = \Application\Entity\Functions::getNombreMesByMesId($date->format('m')) . ' ' . $date->format('Y');
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $data = $modelPersonal->getGraficoPersonalByCategoria($persCode,$fechaIni,$fechaFin);
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'data' => $data,
            'nombre' => $nombre,
        ));
    }
    
    public function personalAction(){
        $tipo = $this->params()->fromQuery('tipo', \Application\Entity\Functions::GRAFICO_CIRCULAR); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '05';
        $fechaFin = $date->format('Ym');
        $nombre = \Application\Entity\Functions::getNombreMesByMesId($date->format('m')) . ' ' . $date->format('Y');
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $data = $modelPersonal->getGraficoPersonalByCliente($persCode,$fechaIni,$fechaFin);
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'data' => $data,
            'nombre' => $nombre,
        ));
    }
    
}
