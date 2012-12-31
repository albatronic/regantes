<?php


/**
 * Description of NoticiasController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 26-nov-2012
 */
class NoticiasController extends ControllerProject {

    var $entity = "Noticias";

    public function IndexAction() {

        /* NOTICIAS */
        $this->values['noticias'] = $this->getNoticias(false);

        return parent::IndexAction();
    }

}

?>
