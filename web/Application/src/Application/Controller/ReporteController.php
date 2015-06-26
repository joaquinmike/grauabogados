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
        $tipo = $this->params()->fromQuery('tipo', NULL); 
        $persCode = $this->params()->fromQuery('codigo', NULL); 
        $site = $this->params()->fromQuery('site', NULL); 
        
        $date = new \DateTime();
        //Fechas
        $fechaIni = $date->format('Y') . '01';
        $fechaFin = $date->format('Ym');
        \Auth\Entity\AuthPersonal::removeFilterPersonal();
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        if($tipo == \Auth\Entity\AuthPersonal::REPORTE_USUARIO){
            $data = $modelPersonal->getGraficoPersonalByCliente($persCode,$fechaIni,$fechaFin);
        }elseif($tipo = \Auth\Entity\AuthPersonal::REPORTE_CATEGORIA){
            $data = $modelPersonal->getGraficoPersonalByCategoria($persCode,$fechaIni,$fechaFin);
        }
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'data' => $data
        ));
    }
    
}
