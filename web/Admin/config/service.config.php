<?php
namespace Admin;

return array(    
   'factories' => array(
       'Form\FormRegistroUsuario' => function($sm){
            return new Form\FormRegistroUsuario($sm);
        },
    ),
);