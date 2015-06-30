<?php

namespace Auth\Entity;

/**
 * Description of AuthPrincipalPe
 *
 * @author joaquin
 */

use Zend\Session\Container;

class AuthPersonal {
    //put your code here
    const ESTADO_ACTIVO = 'A';
    const ESTADO_INACTIVO = 'I';
    
    static function removeFilterPersonal(){
        $sesPersonal = new Container('personal');    
        $sesPersonal->filter = array();
        $sesPersonal->search = NULL;
    }
    
    static function formatGrupoPersonalByPaginator($paginator){
        $result = array();
        foreach ($paginator as $value){
            $result[$value['pert_id']]['cat']['pert_id'] = $value['pert_id'];
            $result[$value['pert_id']]['cat']['pert_nombre'] = $value['pert_nombre'];
            $result[$value['pert_id']]['data'][$value['percod']] = $value;
        }
        return $result;
    }
    
    static function getUrlReportePersonal($codigo,$tipo = \Application\Entity\Functions::GRAFICO_CIRCULAR){
        $url = 'tipo=' . $tipo . '&codigo=' . $codigo;
        return $url;
    }
    
    
}
