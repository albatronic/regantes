<?php

/**
 * Description of AvisoLegalController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class AvisoLegalController extends ControllerProject {

    protected $entity = "AvisoLegal";

    public function IndexAction() {
        
        $this->values['dominio'] = $this->varWeb['Pro']['global']['dominio'];
        $this->values['empresa'] = $this->varWeb['Pro']['global']['empresa'];
        
        return parent::IndexAction();
    }
}

?>
