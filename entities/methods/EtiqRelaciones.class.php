<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 02.01.2013 17:48:05
 */

/**
 * @orm:Entity(EtiqRelaciones)
 */
class EtiqRelaciones extends EtiqRelacionesEntity {

    public function __toString() {
        return $this->getId();
    }

}

?>