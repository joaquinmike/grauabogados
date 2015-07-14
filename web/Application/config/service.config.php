<?php
namespace Application;

use Auth\Model;

return array(    
   'factories' => array(
       'Form\FormUsuarioFiltro' => function($sm){
            return new \Application\Form\FormUsuarioFiltro($sm);
        },
       'Form\FormReportePersonal' => function($sm){
            return new \Application\Form\FormReportePersonal($sm);
        },
       
    ),
);