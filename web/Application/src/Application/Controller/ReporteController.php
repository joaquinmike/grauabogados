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
        return new ViewModel(array(
            'tipo' => $tipo,
            'site' => $site,
            'nombre' => $nombre,
        ));
    }
    
}
