<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 24.12.2012 12:52:25
 */

/**
 * @orm:Entity(VidSecciones)
 */
class VidSecciones extends VidSeccionesEntity {

    public function __toString() {
        return $this->Titulo;
    }

    public function fetchAll($column = '', $default = TRUE) {
        if ($column == '')
            $column = 'Titulo';
        return parent::fetchAll($column, $default);
    }

}

?>