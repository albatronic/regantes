<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @version 1.0 26-nov-2012
 */
class ContactoController extends ControllerProject {

    var $entity = "Contacto";
    var $formContacta = array();

    public function IndexAction() {

        switch ($this->request['METHOD']) {
            case 'GET':
                $this->formContacta = array(
                    'campos' => array(
                        'Nombre' => array('valor' => 'Nombre', 'error' => false),
                        'Email' => array('valor' => 'Email', 'error' => false),
                        'Mensaje' => array('valor' => 'Mensaje', 'error' => false),
                    ),
                );
                break;

            case 'POST':
                $this->formContacta = $this->request['campos'];

                if ($this->Valida()) {
                    if (file_exists('docs/plantillaMail.htm')) {
                        $mensaje = file_get_contents('docs/plantillaMail.htm');
                        $mensaje = str_replace("#EMPRESA#", $this->varWeb['Pro']['global']['empresa'],$mensaje);
                        $mensaje = str_replace("#FECHA#", date('d-m-Y'), $mensaje);
                        $mensaje = str_replace("#HORA#", date('H:m:i'), $mensaje);
                    }

                    $mail = new Mail($this->varWeb['Pro']['mail']);
                    // Envío al visitante
                    $envioOk = $mail->send(
                            $this->formContacta['campos']['Email']['valor'], $this->varWeb['Pro']['mail']['from'], $this->varWeb['Pro']['mail']['from_name'], 'Contacto desde la web', $mensaje, array()
                    );
                    if ($envioOk) {
                        // Envío al web master
                        $envioOk = $mail->send(
                                $this->varWeb['Pro']['mail']['from'], $this->formContacta['campos']['Email']['valor'], $this->formContacta['nombre']['valor'], 'Consulta desde la web', 'Hemos recibido su correo, lo atenderemos en breve', array()
                        );
                    }

                    $this->formContacta['accion'] = 'envio';
                    $this->formContacta['resultado'] = $envioOk;
                    $this->formContacta['mensaje'] = $mail->getError();
                    echo $this->formContacta['mensaje'];
                    unset($mail);
                }
                break;
        }

        $this->values['formContacta'] = $this->formContacta;

        return parent::IndexAction();
    }

    private function Valida() {

        $error = false;

        if (!isset($this->formContacta['leidoPolitica']['valor']))
            $this->formContacta['leidoPolitica']['valor'] = '';

        foreach ($this->formContacta as $campo => $valor) {
            $valor = trim(str_replace($campo, "", $valor['valor']));
            $errorCampo = ($valor == '');
            $this->formContacta['campos'][$campo]['valor'] = $valor;
            $this->formContacta['campos'][$campo]['error'] = $errorCampo;
            $error = ($error or $errorCampo);
        }

        // Comprobar la validez ortográfica de la dirección de correo
        $mail = new Mail($this->varWeb['Pro']['mail']);
        if (!$mail->compruebaEmail($this->formContacta['campos']['Email']['valor'])) {
            $this->formContacta['campos']['Email']['error'] = 1;
            $error = true;
        }

        return !$error;
    }

}

?>
