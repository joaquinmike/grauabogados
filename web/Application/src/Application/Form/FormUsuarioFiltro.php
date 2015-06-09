<?php

namespace Application\Form;

use Util\Form\BaseForm;
/**
 * Description of FormUsuarioFiltro
 *
 * @author joaquin
 */
class FormUsuarioFiltro extends BaseForm {
    //put your code here
    public function __construct($service) {
         parent::__construct();
        //Estado Civil
        $modelPrincipal = $service->get('Model\AuthPrincipalPr');
        $dtaEstadoCivil = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_CIVIL);
        $dtaEstadoCivil = \Application\Entity\Functions::getFormatSelectArray(
                $dtaEstadoCivil, array('id' => 'secucod','value' => 'secudes'),true);
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_civil',
            'attributes' => array(
                'id' => 'pers_civil',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => $dtaEstadoCivil,
            )
        ));
        
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
    }
}
