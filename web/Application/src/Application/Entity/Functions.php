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
    
    const LIMIT_DEFAULT = 16; //limite de registros en un paginado
    const PAGE_RANGE_DEFAULT = 5; //limite de las páginas mostradas en un paginador
    
    const SEXO_MASCULINO = 'M';
    const SEXO_FEMENINO = 'F';
    
    const GRAFICO_CIRCULAR = 1;
    const GRAFICO_BARRAS = 2;
    
    const SITE_PERSONAL = 'personal';
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
            $result[NULL] = ' - ';
        }
        foreach ($data as $value){
            $result[$value[$item['id']]] = $value[$item['value']];
        }
        return $result;
    }
    
    
    static function getBreadCrumb($site,$actual){
        $url = '<li><a href="/">Inicio</a></li>';
        if($site == self::SITE_PERSONAL){
             $url .= '<li><a href="/application/usuario/lista">Personal</a></li>';
        }
        $url .= '<li class="active">' . $actual . '</li>';
        return $url;
    }
    
    static function getNombreMesByAll(){
        return array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        );
        
    }
    
    static function getNombreMesByMesId($mesId = NULL){
        $dtames = self::getNombreMesByAll();
        return $dtames[$mesId];
    }
}