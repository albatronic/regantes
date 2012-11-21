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

        // Cargar la configuracion del modulo (modules/moduloName/config.yml)
        $this->form = new Form($this->entity);


        /**
         * CONTROL DE VISITAS
         *
         * 1. TABLA DE CONTROL DE SESION (sesion, entity, identity, fecha)
         * 2. SE BORRAN (SI NO SE HAN BORRADO ANTES, VAR SESISON DE BORRADO)
         *    LOS REGISTROS DE LA TABLA QUE SEAN ANTERIORES A HOY
         * 3. COMPRUEBO QUE ES UNICO EL TRIO SESION, ENTIDAD, ID.; SIN NO HAGO INSERT
         * 4. INCREMENTAR EL N. VISITAS EN URL AMIGABLES ( SI HE HECHO EL INSERT)
         *
         * 5. CONTROL DETALLE VISITA APOYANDONOS EN LA TABLA ITINERARIO VISITAS
         *
         *
         * PROCESOS PARA AUTOMATIZAR VIA CRON: BORRAR VISITAS NO HUMANAS, WS LOCALIZACION IPS, ETC
         * VOLCADOS DE LOGS
         */
        // LECTURA DE METATAGS      

        /* RUTA // CONSTRUIR AQUÍ EL ARRAY DE LAS RUTAS */
        $this->values['ruta'] = array(
            'seccion1' => array(
                'nombre' => 'Inicio',
                'url' => 'app.path',
            ),
            'seccion2' => array(
                'nombre' => 'Contenido Actual',
                'url' => ''
            ),
        );


        /* MENU CABECERA */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu1='1' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu1 ASC Limit 0,6");
        unset($menu);
        foreach ($rows as $value) {
            $seccion = new GconSecciones($value['Id']);
            $this->values['menuCabecera'][] = array(
                'nombre' => $seccion->getEtiquetaWeb1(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

        /* MENÚ DESPLEGABLE */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu2='1' AND BelongsTo='0' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu2 ASC");
        unset($menu);
        foreach ($rows as $value) {
            $seccion = new GconSecciones($value['Id']);
            $this->values['menuDesplegable'][] = array(
                'seccion' => $seccion->getEtiquetaWeb2(),
                'url' => $seccion->getHref(),
                'subseccion' => $seccion->getArraySubsecciones(),
            );
        }
        unset($seccion);

        /* MENU PIE LEFT */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu3='1' AND Publish='1'";
        $rows = $menu->cargaCondicion("*", $filtro, "OrdenMenu3 ASC");
        unset($menu);
        foreach ($rows as $value) {
            $this->values['menuPie']['left'][] = array(
                'nombre' => $value['EtiquetaWeb3'],
                'url' => $value['UrlFriendly'],
                'controller' => $value['Controller'],
            );
        }

        /* MENU PIE RIGHT */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu4='1' AND Publish='1'";
        $rows = $menu->cargaCondicion("*", $filtro, "OrdenMenu4 ASC");
        unset($menu);
        foreach ($rows as $value) {
            $this->values['menuPie']['right'][] = array(
                'nombre' => $value['EtiquetaWeb4'],
                'url' => $value['UrlFriendly'],
                'controller' => $value['Controller'],
            );
        }
    }

    public function IndexAction() {

        return array(
            'template' => $this->entity . "/Index.html.twig",
            'values' => $this->values,
        );
    }

}

?>
