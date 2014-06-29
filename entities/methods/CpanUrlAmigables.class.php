<?php

/**
 * @author Sergio Perez <sergio.perez@albatronic.com>
 * @copyright INFORMATICA ALBATRONIC SL
 * @date 30.09.2012 16:42:34
 */

/**
 * @orm:Entity(CpanUrlAmigables)
 */
class CpanUrlAmigables extends CpanUrlAmigablesEntity {

    public function __toString() {
        return $this->getId();
    }

    /**
     * LLama al método erase
     *
     * @return bollean
     */
    public function delete() {

        return $this->erase();
    }

    /**
     * Borra físicamente un registro (delete) y quita los valores
     * relacionados con la url amigable en la entidad relacionada
     *
     * @return boolean
     */
    public function erase() {

        // Quito de la entidad asociada los valores de la url amigable
        if (class_exists($this->Entity)) {
            $entidadAsociada = new $this->Entity($this->IdEntity);
            if (!$entidadAsociada->getStatus())
                $entidadAsociada = $entidadAsociada->find($entidadAsociada->getPrimaryKeyName(), $this->IdEntity, true);

            $entidadAsociada->setUrlPrefix('');
            $entidadAsociada->setSlug('');
            $entidadAsociada->setUrlFriendly('');
            $entidadAsociada->save();
        }

        $this->conecta();

        if (is_resource($this->_dbLink)) {
            $query = "DELETE FROM `{$this->_dataBaseName}`.`{$this->_tableName}` WHERE `{$this->_primaryKeyName}` = '{$this->getPrimaryKeyValue()}'";
            if (!$this->_em->query($query))
                $this->_errores = $this->_em->getError();

            $this->_em->desConecta();
        } else
            $this->_errores = $this->_em->getError();

        unset($this->_em);

        $ok = (count($this->_errores) == 0);

        return $ok;
    }

    /**
     * Comprueba que no exista otra url igual
     */
    public function validaLogico() {

        $url = new CpanUrlAmigables();
        $rows = $url->cargaCondicion("Id","Idioma='{$_SESSION['idiomas']['actual']}' and UrlFriendly='{$this->UrlFriendly}'");

        if ($rows[0]['Id'] != $this->getPrimaryKeyValue()) {
            if (!$this->getPrimaryKeyValue())
                $this->_errores[] = "Ya existe un objeto con esa Url. Entidad = {$url->getEntity()}, IdEntidad= {$url->getIdEntity()}";
        }
        unset($url);

        if (count($this->_errores) == 0)
            $this->actualizaEntidadReferenciada();
    }

    public function actualizaEntidadReferenciada() {

        if (class_exists($this->Entity)) {
            $objeto = new $this->Entity($this->IdEntity);
            $objeto->setSlug(str_replace("/", "", $this->UrlFriendly));
            $objeto->setUrlFriendly($this->UrlFriendly);
            $ok = $objeto->save();
            unset($objeto);
        }

        if (!$ok)
            $this->_errores[] = "No se ha podido actualizar la url en la entidad referenciada '{$this->Entity}({$this->IdEntity})'. Es posible que esa Entidad/IdEntidad no exista.";
    }

    /**
     * Borrar el registro de urlamigables correspondiente al $idioma, $entidad y $idEntidad
     *
     * @param int $idioma
     * @param string $entidad
     * @param integer $idEntidad
     * @return boolean TRUE si el borrado se hizo con éxito
     */
    public function borraUrl($idioma, $entidad, $idEntidad) {

        $row = $this->cargaCondicion("Id", "Idioma='{$idioma}' and Entity='{$entidad}' and IdEntity='{$idEntidad}'");
        $url = new CpanUrlAmigables($row[0]['Id']);
        $ok = $url->erase();
        unset($url);

        return $ok;
    }

}

?>