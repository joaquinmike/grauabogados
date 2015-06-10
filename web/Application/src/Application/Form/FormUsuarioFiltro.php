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
        $dtaTipo = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_TIPO_PERSONAL);
        $dtaTipo = \Application\Entity\Functions::getFormatSelectArray($dtaTipo, array('id' => 'secucod','value' => 'secudes'));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_tipo',
            'attributes' => array(
                'id' => 'pers_tipo',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => $dtaTipo,
            )
        ));
        
        $dtaEstadoCivil = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_CIVIL);
        $dtaEstadoCivil = \Application\Entity\Functions::getFormatSelectArray($dtaEstadoCivil, array('id' => 'secucod','value' => 'secudes'));
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
        
        $dtaCargo = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_CARGO);
        $dtaCargo = \Application\Entity\Functions::getFormatSelectArray($dtaCargo, array('id' => 'secucod','value' => 'secudes'));
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
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_sexo',
            'attributes' => array(
                'id' => 'pers_sexo',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => array(
                    '' => ' - ',
                    \Application\Entity\Functions::SEXO_MASCULINO => 'Masculino',
                    \Application\Entity\Functions::SEXO_FEMENINO => 'Femenino'
                ),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'pers_estado',
            'attributes' => array(
                'id' => 'pers_estado',
                'class' => 'form-control',
                'onchange' => 'getFilterPersonal()',
            ),
            'options' => array(
                'value_options' => array(
                    '' => ' - ',
                    \Auth\Entity\AuthPersonal::ESTADO_ACTIVO => 'Activo',
                    \Auth\Entity\AuthPersonal::ESTADO_INACTIVO => 'Inactivo'
                ),
            )
        ));
    }
}
