<?php

/**
 * Description of EventosController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC
 * @date 15-01-2013
 */
class EventosController extends ControllerProject {

    var $entity = "Eventos";

    public function IndexAction() {

        if ($this->request[1]) {
            $fecha = explode("-", $this->request[1]);
            $mes = $fecha[1];
            $ano = $fecha[0];
            $this->values['calendario'] = $this->getCalendario($mes, $ano);
            $this->values['eventos'] = $this->getEventos($this->request[1], $this->request[1], 0, 2, false);
        } else
            $this->values['eventos'] = $this->getEventos('','', 0, 2, false);

        return parent::IndexAction();
    }

}

?>
