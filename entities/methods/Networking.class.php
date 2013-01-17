<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 16.01.2013 19:04:53
 */

/**
 * @orm:Entity(Networking)
 */
class Networking extends NetworkingEntity {

    public function __toString() {
        return $this->getId();
    }

}

?>