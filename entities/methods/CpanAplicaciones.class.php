<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 20:33:06
 */

/**
 * @orm:Entity(CpanAplicaciones)
 */
class CpanAplicaciones extends CpanAplicacionesEntity {
	public function __toString() {
		return $this->getId();
	}
}
?>