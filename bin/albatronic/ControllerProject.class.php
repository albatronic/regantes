<?php

/**
 * CONTROLADOR DE PROYECTO. EXTIENDE AL CONTROLADOR WEB
 * 
 * El constructor realiza las tareas comunes al proyecto como por ej.
 * construir la ruta de navegación y los menús
 *
 * @author Sergio Pérez
 * @copyright Ártico Estudio, SL
 * @version 1.0 26-nov-2012
 */
class ControllerProject extends ControllerWeb {

    public function __construct($request) {

        parent::__construct($request);

        /* CONSTRUIR AQUÍ EL ARRAY DE LAS RUTAS */
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

        /* CALENDARIO */
        $this->values['calendario'] = array(
            'calendario' => Calendario::showCalendario('', '', true),
            'mesTexto' => Calendario::getMes(1),
            'mesNumero' => Calendario::getMes(0),
            'ano' => Calendario::getAno(),
        );

        /* USTED ESTA EN */
        $this->values['ustedEstaEn'] = array(
            'titulo' => 'Contacto',
            'subsecciones' => array(
                'Sub pepito' => 'http://asdfasdf',
                'Sub manolito' => 'http://asdfasdfasdfasdf',
                'Sub sdfg' => 'http://asdfasdfasdfasdf',
                'Aenean consequat iaculis arcu sit amet faucibus. Fusce posuere posuere scelerisque.' => 'http://asdfasdfasdfasdf',
            ),
        );

        /* MENU CABECERA */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu2='1' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu1 ASC Limit 0,6");
        unset($menu);
        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $this->values['menuCabecera'][] = array(
                'nombre' => $seccion->getEtiquetaWeb2(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

        /* MENÚ DESPLEGABLE */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu1='1' AND BelongsTo='0' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu2 ASC");
        unset($menu);
        foreach ($rows as $row) {
            $subseccion = new GconSecciones($row['Id']);
            $this->values['menuDesplegable'][] = array(
                'seccion' => $subseccion->getEtiquetaWeb1(),
                'url' => $subseccion->getHref(),
                'subsecciones' => $subseccion->getArraySubsecciones(),
            );
        }
        unset($seccion);

        /* MENU PIE */
        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu3='1' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu3 ASC");
        unset($menu);
        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $this->values['menuPie'][] = array(
                'nombre' => $seccion->getEtiquetaWeb3(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

    }

}

?>
