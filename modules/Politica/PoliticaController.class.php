<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class PoliticaController extends ControllerWeb {

    protected $entity = "Politica";

    public function IndexAction() {

                
        
        return array(
            'template' => $this->entity . '/Index.html.twig',
            'values' => $this->values
        );
    }

}

?>
