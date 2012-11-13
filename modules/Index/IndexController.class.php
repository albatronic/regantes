<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class IndexController extends ControllerWeb {

    protected $entity = "Index";

    public function IndexAction() {

        /**
         * PONER AQUI LA LÓGICA NECESARIA Y CONSTRUIR
         * EL ARRAY DE VALORES '$this->values'
         */
        
        $this->values['ustedEstaEn'][] = array(
            'seccion' => 'Inicio',
            'entradaSeccion1' => 'http://www.google.es',
            'entradaSeccion2' => 'enlace a la Sección 2',
        );
        
        
        return array(
            'template' => $this->entity . '/Index.html.twig',
            'values' => $this->values
        );
    }

}

?>
