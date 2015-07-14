<?php
namespace Application;

return array(    
   'factories' => array(
       'Form\FormUsuarioFiltro' => function($sm){
            return new Form\FormUsuarioFiltro($sm);
        },
       'Form\FormReportePersonal' => function($sm){
            return new Form\FormReportePersonal($sm);
        },
       
    ),
);