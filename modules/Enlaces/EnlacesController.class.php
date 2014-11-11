<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC
 * @date 06-nov-2012
 *
 */
class EnlacesController extends ControllerProject {

    protected $entity = "Enlaces";

    public function IndexAction() {

        /* ENLACES DE INTERES */
        $this->values['seccionesEnlaces'] = $this->getSeccionesDeEnlaces();

        return parent::IndexAction();
    }

    /**
     * Muestra los enlaces de interés de una sección de enlaces.
     * 
     * @return array
     */
    public function ListadoAction() {

        /* ENLACES DE INTERES */
        $this->values['enlacesInteres'] = $this->getEnlacesDeInteres($this->request['IdEntity']);

        return array(
            'template' => $this->entity . '/listado.html.twig',
            'values' => $this->values
        );
    }

}

?>
