<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class AccesoController extends ControllerWeb {

    protected $entity = "Acceso";

    public function AccesoAction() {

        /**
         * PONER AQUI LA LÓGICA NECESARIA Y CONSTRUIR
         * EL ARRAY DE VALORES '$this->values'
         */
        return array(
            'template' => $this->entity . '/Index.html.twig',
            'values' => $this->values
        );
    }

}

?>
