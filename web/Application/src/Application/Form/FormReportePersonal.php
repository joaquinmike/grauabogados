<?php

namespace Application\Form;

use Util\Form\BaseForm;
/**
 * Description of FormReportePersonal
 *
 * @author joaquinmike
 */
class FormReportePersonal extends BaseForm {
    //put your code here
    public function __construct($service) {
        parent::__construct();
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'anio_start',
            'attributes' => array(
                'id' => 'anio_start',
                'class' => 'form-control',
                'onchange' => 'getGenerarGrafico()',
            ),
            'options' => array(
                'value_options' => self::getAniosForForm(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'anio_end',
            'attributes' => array(
                'id' => 'anio_end',
                'class' => 'form-control',
                'onchange' => 'getGenerarGrafico()',
            ),
            'options' => array(
                'value_options' => self::getAniosForForm(),
            )
        ));
        
        $dtaMeses = \Application\Entity\Functions::getNombreMesByAll();
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'mes_start',
            'attributes' => array(
                'id' => 'mes_start',
                'class' => 'form-control',
                'onchange' => 'getGenerarGrafico()',
            ),
            'options' => array(
                'value_options' => $dtaMeses,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'mes_end',
            'attributes' => array(
                'id' => 'mes_end',
                'class' => 'form-control',
                'onchange' => 'getGenerarGrafico()',
            ),
            'options' => array(
                'value_options' => $dtaMeses,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'date_start',
            'attributes' => array(
                'id' => 'date_start',
                'class' => 'form-control',
                'contenteditable' => 'false'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'date_end',
            'attributes' => array(
                'id' => 'date_end',
                'class' => 'form-control',
            ),
        ));
         
         
        $modelPrincipal = $service->get('Model\AuthPrincipalPr');
        $dtaArea = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_AREA);
        $dtaArea = \Application\Entity\Functions::getFormatSelectArray($dtaArea, array('id' => 'secucod','value' => 'secudes'));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_area',
            'attributes' => array(
                'id' => 'pers_area',
                'class' => 'form-control',
                'onchange' => 'getListaPersonal(this)',
            ),
            'options' => array(
                'value_options' => $dtaArea,
            )
        ));
    }
    
    static function getAniosForForm(){
        $start = 2010; $end = date('Y');
        $result = array();
        for($i = $start; $i <= $end; $i++){
            $result[$i] = $i;
        }
        return $result;
    }
}
