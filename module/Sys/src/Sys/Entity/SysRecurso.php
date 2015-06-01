<?php

/**
 * Description of SysRecurso
 *
 * @author joaquinmike
 */

namespace Sys\Entity;

class SysRecurso {
    
    const TIPO_MENU = 1;
    const TIPO_RECURSO = 2;
    
    const ESTADO_PERMISO = 'allow';
    
    /**
     * 
     * @param type $data
     */
    static function getConvertRecursoToMenu($data){
        $recursoId = NULL; $result = array();
        foreach ($data as $value){
            if(empty($value['rec_recurso_id'])){
                $result[$value['recurso_id']] = $value;
            }else{
                $value['recurso_link'] = str_replace(':', '/', $value['recurso_uri']);
                $value['recurso_uri'] = str_replace('adm', 'application', $value['recurso_uri']);
                $result[$value['rec_recurso_id']]['submenu'][$value['recurso_id']] = $value;
            }
        }
        return $result;
    }
}
