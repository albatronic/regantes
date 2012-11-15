<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 20:33:07
 */

/**
 * @orm:Entity(CpanUsuariosTipos)
 */
class CpanUsuariosTipos extends CpanUsuariosTiposEntity {
	public function __toString() {
		return $this->getId();
	}
}
?>