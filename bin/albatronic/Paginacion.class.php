<?php

/**
 * CLASE PARA PAGINAR
 * 
 * En base a los parámetros obtiene el subconjunto de datos correspondiente a la página $nPagina. 
 * 
 * Con los métodos get se obtiene la información elaborada.
 * 
 * 
 * @param string $entidad La entidad de datos a paginar
 * @param string $filtro Clausula where para filtrar los datos (sin el WHERE)
 * @param string $criterioOrden Criterio de ordenación de los datos (sin el ORDER BY)
 * @param int $nPagina Número de pagina a devolver
 * @param int $itemsPorPagina Número de items por página
 * @return array Array con la información obtenida
 * 
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright (c) Ártico Estudio, sl
 * @version 1.0 22-ENE-2013
 */
class Paginacion {

    static $rows;
    static $pagina;
    static $totalPaginas;
    static $itemsPorPagina;
    static $totalItems;
    
    static function paginar($entidad, $filtro, $criterioOrden, $nPagina, $itemsPorPagina) {

        self::$pagina = $nPagina;
        self::$itemsPorPagina = $itemsPorPagina;
        
        $objeto = new $entidad();

        $query = "SELECT Id from {$objeto->getDataBaseName()}.{$objeto->getTableName()} WHERE {$filtro} ORDER BY {$criterioOrden}";

        $em = new EntityManager($objeto->getConectionName());
        if ($em->getDbLink()) {
            $em->query($query);
            self::$totalItems = $em->numRows();
            self::$totalPaginas = floor(self::$totalItems / self::$itemsPorPagina);
            if ((self::$totalItems % self::$itemsPorPagina) > 0)
                self::$totalPaginas++;
            $offset = (self::$pagina - 1) * self::$itemsPorPagina;
            self::$rows = $em->fetchResultLimit(self::$itemsPorPagina, $offset);
            $em->desConecta();
        }
        unset($objeto);
        unset($em);

    }
    
    /**
     * Array con N ocurrencias: ('Id' => el id del objeto obtenido)
     * @return array
     */
    static function getRows() {
        return self::$rows;
    }
    
    /**
     * Devuelve el número de página solicitado
     * @return int El número de página
     */
    static function getPagina() {
        return self::$pagina;
    }

    /**
     * Devuelve el número total de páginas
     * @return int 
     */
    static function getTotalPaginas() {
        return self::$totalPaginas;
    }
    
    /**
     * Devuelve el número de registros por página
     * @return int
     */
    static function getItemsPorPagina() {
        return self::$itemsPorPagina;
    }
    
    /**
     * Devuelve el número total de items que cumplen el criterio de filtro
     * @return int
     */
    static function getTotalItems() {
        return self::$totalItems;
    }
}

?>
