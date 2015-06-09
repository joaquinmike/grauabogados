<?php

/**
 * Description of Functions
 *
 * @author joaquinmike
 */

namespace Application\Entity;

class Functions {
    
    const ESTADO_ACTIVO = 1;
    const ESTADO_INACTIVO = 0;
    
    const RECURSO_DEFAULT = 'application:index:index';
    
    const LIMIT_DEFAULT = 10; //limite de registros en un paginado
    const PAGE_RANGE_DEFAULT = 5; //limite de las páginas mostradas en un paginador
    
    /**
     * 
     * @param type $data
     * @param type $item
     * @param type $default
     * @return type
     */
    static function getFormatSelectArray($data,$item,$default = true){
        $result = array();
        if($default){
            $result[NULL] = '-Seleccionar-';
        }
        foreach ($data as $value){
            $result[$value[$item['id']]] = $value[$item['value']];
        }
        return $result;
    }
    
}