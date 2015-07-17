<?php

namespace Admin\Form;

use Util\Form\BaseForm;
/**
 * Description of FormRegistroUsuario
 *
 * @author joaquinmike
 */
class FormRegistroUsuario extends BaseForm {
    //put your code here
    public function __construct($service) {
         parent::__construct();
    
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'us_usuario',
            'attributes' => array(
                'id' => 'us_usuario',
                'class' => 'form-control',
                'placeholder' => 'username',
                'required' => '',
                'aria-required' => 'true',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'us_password',
            'attributes' => array(
                'id' => 'us_password',
                'class' => 'form-control',
                'required' => '',
                'aria-required' => 'true',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'us_rol',
            'attributes' => array(
                'id' => 'us_rol',
                'class' => 'form-control',
                'required' => '',
                'aria-required' => 'true',
            ),
            'options' => array(
                'value_options' => array('' => '',1 => 'Administrador'),
            )
        ));
        
        $modelPrincipal = $service->get('Model\AuthPrincipalPr');
        $dtaArea = $modelPrincipal->getDataFiltroByCode(\Auth\Entity\AuthPrincipalPr::COD_AREA);
        $dtaArea = \Application\Entity\Functions::getFormatSelectArray($dtaArea, array('id' => 'secucod','value' => 'secudes'));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'us_area',
            'attributes' => array(
                'id' => 'us_area',
                'class' => 'form-control',
                'required' => '',
                'aria-required' => 'true',
            ),
            'options' => array(
                'value_options' => $dtaArea,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'us_persona',
            'attributes' => array(
                'id' => 'us_persona',
                'class' => 'form-control',
                'required' => '',
                'aria-required' => 'true',
            ),
            'options' => array(
                'value_options' => array(),
            )
        ));
    }
}
