<?php

/**
 * Description of ControllerWeb
 *
 * Controlador común a todos los módulos
 *
 * @author Administrador
 */
class ControllerWeb {

    /**
     * Variables enviadas en el request por POST o por GET
     * @var request
     */
    protected $request;

    /**
     * Objeto de la clase 'form' con las propiedades y métodos
     * del formulario obtenidos del fichero de configuracion
     * del formulario en curso
     * @var from
     */
    protected $form;

    /**
     * Valores a devolver al controlador principal para
     * que los renderice con el twig correspondiente
     * @var array
     */
    protected $values;

    /**
     * Objeto de la clase 'controlAcceso'
     * para gestionar los permisos de acceso a los métodos del controller
     * @var ControlAcceso
     */
    protected $permisos;

    /**
     * Array con las variables Web del modulo
     * @var array
     */
    protected $varWeb;

    public function __construct($request) {

        // Cargar lo que viene en el request
        $this->request = $request;

        // Borrar la tabla temporal de visitas
        if (!$_SESSION['borradoTemporalVisitas']) {
            $temp = new VisitVisitasTemporal();
            $temp->borraTemporal();
            unset($temp);
        }

        // Control de visitas UNICAS a la url amigable
        $temp = new VisitVisitasTemporal();
        $temp->anotaVisitaUrlUnica($this->request['IdUrlAmigable']);
        unset($temp);

        // Anotar en el registro de visitas
        $visita = new VisitVisitas();
        $visita->anotaVisita($this->request);
        unset($visita);
        
        /**
         *
         * PROCESOS PARA AUTOMATIZAR VIA CRON: BORRAR VISITAS NO HUMANAS, WS LOCALIZACION IPS, ETC
         * VOLCADOS DE LOGS
         * 
         */
        
        // LECTURA DE METATAGS 
               
    }

    public function IndexAction() {

        return array(
            'template' => $this->entity . "/index.html.twig",
            'values' => $this->values,
        );
    }

}

?>
