<?php
namespace Application;

return array(    
   'factories' => array(
       'Form\FormUsuarioFiltro' => function($sm){
            return new \Application\Form\FormUsuarioFiltro($sm);
        },
       
    ),
);