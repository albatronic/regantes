<?php

/**
 * Description of NoticiasController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC
 * @date 26-nov-2012
 */
class NoticiasController extends ControllerProject {

    var $entity = "Noticias";

    public function IndexAction() {

        /* NOTICIAS */
      
        $pagina = $this->request[1];
        if ($pagina<=0) $pagina = 1;

        $this->values['noticias'] = $this->getNoticias(false,0,$pagina,2);

        return parent::IndexAction();
    }

}

?>
