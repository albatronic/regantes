<?php
/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 06.11.2012 20:33:06
 */

/**
 * @orm:Entity(CpanFuncionalidades)
 */
class CpanFuncionalidades extends CpanFuncionalidadesEntity {
	public function __toString() {
		return $this->getId();
	}
}
?>