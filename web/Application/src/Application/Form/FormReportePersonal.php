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
        
        $modelPrincipal = $service->get('Model\AuthPrincipalPr');
        $dtaArea = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_AREA);
        $dtaArea = \Application\Entity\Functions::getFormatSelectArray($dtaArea, array('id' => 'secucod','value' => 'secudes'));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_area',
            'attributes' => array(
                'id' => 'pers_area',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => $dtaArea,
            )
        ));
        
        $modelPersonal = $this->getServiceLocator()->get('Model\AuthPersonal');
        $paginator = $modelPersonal->getPersonalAllByOrder($page,$sesPersonal->filter,$sesPersonal->search);
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_cargo',
            'attributes' => array(
                'id' => 'pers_cargo',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => $dtaCargo,
            )
        ));
    }
}
