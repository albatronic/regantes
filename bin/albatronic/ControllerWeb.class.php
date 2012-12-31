<?php

/**
 * Description of ControllerWeb
 *
 * Controlador común a todos los proyectos web
 *
 * @author Sergio Pérez
 * @copyright Ártico Estudio, SL
 * @version 1.0 1-dic-2012
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

    /**
     * Carga las variables web del proyecto
     * Borra la tabla temporal de visitas según la frecuencia de borrado indicada en el config.yml
     * Controla el número de visitas únicas a cada url
     * Almacena el registro de visitas
     * 
     * @param array $request Array con el request
     */
    public function __construct($request) {

        // Cargar lo que viene en el request
        $this->request = $request;

        // Cargar las variables web del proyecto en la variable de sesion y en $this->varWeb['Pro']
        // de esta forma solo se cargaran la primera vez
        $this->setVariables('Pro');

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

    /**
     * Devuelve un array con dos elementos:
     * 
     * - 'template' => el template a devolver
     * - 'values' => array con los valores obtenidos
     * 
     * @return array Array template y values
     */
    public function IndexAction() {

        return array(
            'template' => $this->entity . "/index.html.twig",
            'values' => $this->values,
        );
    }

    /**
     * Llena el array con las variables web del proyecto o del módulo
     * 
     * @param string $ambito EL ámbito de las variables: Pro ó Mod
     * @param string $modulo El nombre del modulo. Opcional. Por defecto el indicado en $this->request['Entity']
     */
    protected function setVariables($ambito, $modulo = '') {

        if ($modulo == '')
            $modulo = $this->request['Entity'];

        switch ($ambito) {
            case 'Pro':
                if (($_SESSION['EntornoDesarrollo']) or (!is_array($_SESSION['varWeb']['Pro']))) {
                    $filtro = "IdProyectosApps='{$_SESSION['projectId']}' and Variable='varPro_Web'";
                    $variables = new CpanVariables();
                    $rows = $variables->cargaCondicion('Yml', $filtro);
                    unset($variables);

                    $_SESSION['varWeb']['Pro'] = sfYaml::load($rows[0]['Yml']);
                }
                $this->varWeb['Pro'] = $_SESSION['varWeb']['Pro'];
                break;
            case 'Mod':
                if (($_SESSION['EntornoDesarrollo']) or (!is_array($_SESSION['varWeb']['Mod'][$modulo]))) {
                    $filtro = "IdProyectosApps='{$_SESSION['projectId']}' and Variable='varMod_{$modulo}_Web'";
                    $variables = new CpanVariables();
                    $rows = $variables->cargaCondicion('Yml', $filtro);
                    unset($variables);

                    $_SESSION['varWeb']['Mod'][$modulo] = sfYaml::load($rows[0]['Yml']);
                }
                $this->varWeb['Mod'][$modulo] = $_SESSION['varWeb']['Mod'][$modulo];
                break;
        }
    }

    /**
     * Genera el array 'firma' de forma aletoria en base
     * la variable web del proyecto 'signatures'
     * 
     * El array tiene tres elementos:
     * 
     * - url => 'texto'
     * - location => 'texto'
     * - service => 'texto'
     * 
     * @return array Array con la firma de la web
     */
    protected function getFirma() {

        $links = explode(",", $this->varWeb['Pro']['signatures']['links']);
        $link = trim($links[rand(0, count($links) - 1)]);

        $locations = explode(",", $this->varWeb['Pro']['signatures']['locations']);
        $location = trim($locations[rand(0, count($locations) - 1)]);

        $idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        if (!is_array($this->varWeb['Pro']['signatures']['services'][$idioma]))
            $idioma = 'es';

        $services = explode(",", $this->varWeb['Pro']['signatures']['services'][$idioma]);
        $service = trim($services[rand(0, count($services) - 1)]);

        return array(
            'url' => $link,
            'location' => $location,
            'service' => $service,
        );
    }

    /**
     * Genera el array 'ruta' con todas las entidades
     * padre del objeto en curso
     * 
     * El array tiene dos elementos:
     * 
     *  - nombre => 'texto',
     *  - url => array(
     *                  url => 'texto con la url completa incluido http::// ó https://'
     *                  tartgetBlank => boolean
     *              )
     *              
     * @return array Array con la ruta en la que está el visitante web
     */
    protected function getRuta() {

        $array = array();

        $seccion = new GconSecciones($this->request['IdEntity']);
        $ruta = $seccion->getPadres();
        foreach ($ruta as $IdPadre) {
            $seccion = new GconSecciones($IdPadre);
            $array[] = array(
                'nombre' => $seccion->getTitulo(),
                'url' => $seccion->getHref(),
            );
        }
        unset($seccion);

        return $array;
    }

    /**
     * Genera el array 'calendario' del mes y año en curso
     * incluyendo las marcas en los días que haya eventos
     * 
     * Los elmentos del array son:
     * 
     * - calendario => texto html con el calendario
     * - mesTexto => El nombre del mes
     * - mesNumero => El número del mes
     * - ano => el número del año con cuatro cifras
     * 
     * @param integer $mes EL número de mes. Opcional. Por defecto el mes en curso
     * @param integer $ano El año. Opcional. Por defecto el año en curso
     * @return array Array con los elementos del calendio
     */
    protected function getCalendario($mes = '', $ano = '') {
        return array(
            'calendario' => Calendario::showCalendario($mes, $ano, true),
            'mesTexto' => Calendario::getMes(1),
            'mesNumero' => Calendario::getMes(0),
            'ano' => Calendario::getAno(),
        );
    }

    /**
     * Genera el array 'ustedEstaEn'
     * 
     * El array tiene dos elementos:
     * 
     * - titulo => texto
     * - subsecciones => array con n elmentos numerados del 0 al N (
     *                          titulo => texto
     *                          url => array(url => texto, targetBlank => boolean)
     *                      )
     * 
     * @return array Array con los elmentos de 'ustedEntaEn'
     */
    protected function getUstedEstaEn() {
        switch ($this->request['Entity']) {
            case 'GconSecciones':
                break;
            case 'GconContenidos':
                break;
        }

        $objeto = new $this->request['Entity']($this->request['IdEntity']);
        $array = array(
            'titulo' => $objeto->getTitulo(),
            'subsecciones' => $objeto->getArraySubsecciones(),
        );
        unset($objeto);

        return $array;
    }

    /**
     * Genera el array del menu indicado en $nMenu en base a las SECCIONES que:
     * 
     *      MostrarEnMenuN = 1
     *      Publish = 1
     * 
     * El array tiene cinco elementos:
     * 
     * - etiquetaWeb => texto de la etiquetaWebN
     * - titulo => el titulo de la seccion
     * - subtitulo => el subtitulo de la seccion
     * - url => array(url => texto, targetBlank => boolean)
     * - controller => texto con el nombre del controlador
     * 
     * @param int $nMenu El número de menu a mostrar (de 1 a 5). Por defecto 1
     * @param int $nItems El numero máximo de elementos a devolver. (0=todos)
     * @return array Array con las secciones que son menú
     */
    protected function getMenuN($nMenu = 1, $nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $seccion = new GconSecciones();
        $filtro = "MostrarEnMenu{$nMenu}='1' AND Publish='1'";
        $rows = $seccion->cargaCondicion("Id", $filtro, "OrdenMenu{$nMenu} ASC {$limite}");

        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $array[] = array(
                'etiquetaWeb' => $seccion->{"getEtiquetaWeb$nMenu"}(),
                'titulo' => $seccion->getTitulo(),
                'subtitulo' => $seccion->getSubtitulo(),
                'url' => $seccion->getHref(),
                'controller' => $seccion->getObjetoUrlAmigable()->getController(),
            );
        }
        unset($seccion);

        return $array;
    }
    
    /**
     * Genera el array del menu desplegable en base a las secciones que:
     * 
     *      MostrarEnMenu1 = 1
     *      BelongsTo = 0
     *      Publish = 1
     * 
     * El array tiene tres elementos:
     * 
     * - seccion => texto de la etiquetaWeb1
     * - url => array(url => texto, targetBlank => boolean)
     * - subsecciones => array de 0 a N (
     *                          titulo => texto
     *                          url => array(url => texto, targetBlank => boolean)
     *                      )
     * 
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional. (0=todos)
     * @return array Array con las secciones
     */
    protected function getMenuDesplegable($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu1='1' AND BelongsTo='0' AND Publish='1'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu1 ASC {$limite}");
        unset($menu);

        foreach ($rows as $row) {
            $subseccion = new GconSecciones($row['Id']);
            $array[] = array(
                'seccion' => $subseccion->getEtiquetaWeb1(),
                'url' => $subseccion->getHref(),
                'subsecciones' => $subseccion->getArraySubsecciones(),
            );
        }
        unset($subseccion);

        return $array;
    }

    protected function getContenido($idContenido, $arrayColumnas) {

        $array = array();

        $contenido = new GconContenidos($idContenido);

        foreach ($arrayColumnas as $columna) {
            $array[$columna] = $contenido->{"get$columna"}();
        }

        return $array;
    }

    /**
     * Genera el array con las noticias en base a los CONTENIDOS que:
     * 
     *      NoticiaPublicar = 1
     *      Publish = 1
     * 
     * Si las noticias a devolver son las de portada, además se tiene en cuenta
     * las variables web del módulo GconContenidos:
     * 
     * - NumNoticasMostrarHome, y
     * - NumNoticasPorPagina
     * 
     * El array tiene 7 elementos
     * 
     * - fecha => la fecha de publicación (PublisehAt)
     * - titulo => titulo de la noticia
     * - subtitulo => subtitulo de la noticia
     * - url => array(url => texto, targetBlank => boolean)
     * - resumen => texto del resumen
     * - desarrollo => texto del desarrollo
     * - imagen => Path de la imagen de diseño 1
     * 
     * @param boolean $enPortada Si TRUE se devuelven solo las que están marcadas como portada, 
     * en caso contrario se devuelven todas las noticias
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional.
     * Si no se indica valor, se mostrará el número de noticias indicado en las variables
     * web 'NumNoticasMostrarHome' o 'NumNoticasPorPagina' dependiendo de $enPortada
     * @return array Array con las noticias
     */
    protected function getNoticias($enPortada = true, $nItems = 0) {

        $array = array();

        if ($nItems <= 0) {
            $this->setVariables('Mod', 'GconContenidos');
            $nItems = ($enPortada) ?
                    $this->varWeb['Mod']['GconContenidos']['NumNoticasMostrarHome'] :
                    $this->varWeb['Mod']['GconContenidos']['NumNoticasPorPagina'];
        }

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";
        $filtro = "NoticiaPublicar='1' AND Publish='1'";
        if ($enPortada)
            $filtro .= " AND NoticiaMostrarEnPortada='{$enPortada}'";
        $criterioOrden = $this->varWeb['Mod']['GconContenidos']['CriterioOrdenNoticias'];

        $noticia = new GconContenidos();
        $rows = $noticia->cargaCondicion("Id", $filtro, "{$criterioOrden} {$limite}");

        foreach ($rows as $row) {
            $noticia = new GconContenidos($row['Id']);
            $documentos = $noticia->getDocuments('image1');
            $imagen = ($documentos[0]) ? $documentos[0]->getPathName() : "";
            $array[] = array(
                'fecha' => $noticia->getPublishedAt(),
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getObjetoUrlAmigable()->getHref(),
                'resumen' => $this->limpiaTiny($noticia->getResumen()),
                'desarrollo' => $this->limpiaTiny($noticia->getDesarrollo()),
                'imagen' => $imagen,
            );
        }
        unset($noticia);
        unset($documentos);

        return $array;
    }

    /**
     * Genera el array con las noticias más leidas
     * 
     * Las noticias son Contenidos que tiene a TRUE los campos
     * NoticiaPublicar y Publish
     * 
     * Las noticias se ordenan descendentemente por número de visitas (NumberVisits)
     * 
     * Si no se indica el parámetro $nItems, se buscará el valor de la variable
     * web 'NumNoticasMostrarHome'
     * 
     * El array tiene 7 elementos:
     * 
     * - fecha => la fecha de publicación (PublishedAt)
     * - titulo => el titulo de la noticia (seccion)
     * - subtitulo => el subtitulo de la noticia (seccion)
     * - url => array(url => texto, targetBlank => boolean)
     * - resumen => el resumen de la noticia (seccion)
     * - desarrollo => el desarrollo de la noticia
     * - imagen => Path de la imagen de diseño 1
     * 
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional.
     * Si no se indica valor, se mostrarán las indicadas en la VW 'NumNoticasMostrarHome'
     * @return array Array con las noticias
     */
    protected function getNoticiasMasLeidas($nItems = 0) {

        $array = array();

        if ($nItems <= 0) {
            $this->setVariables('Mod', 'GconContenidos');
            $nItems = $this->varWeb['Mod']['GconContenidos']['NumNoticasMostrarHome'];
        }

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $noticia = new GconContenidos();
        $filtro = "NoticiaPublicar='1' AND Publish='1'";

        $rows = $noticia->cargaCondicion("Id", $filtro, "NumberVisits DESC {$limite}");

        foreach ($rows as $row) {
            $noticia = new GconContenidos($row['Id']);
            $documentos = $noticia->getDocuments('image1');
            $imagen = ($documentos[0]) ? $documentos[0]->getPathName() : "";
            $array[] = array(
                'fecha' => $noticia->getPublishedAt(),
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getObjetoUrlAmigable()->getHref(),
                'resumen' => $this->limpiaTiny($noticia->getResumen()),
                'desarrollo' => $this->limpiaTiny($noticia->getDesarrollo()),
                'imagen' => $imagen,
            );
        }
        unset($noticia);
        unset($documentos);

        return $array;
    }

    /**
     * Genera el array con las contenidos más visitados
     * 
     * 
     * Las contenidos se ordenan descendentemente por número de visitas (NumberVisits)
     * 
     * El array tiene 2 elementos:
     * 
     * - subtitulo => el subtitulo de la noticia (seccion)
     * - url => array(url => texto, targetBlank => boolean)
     * 
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional. (0=todos)
     * @return array Array con los contenidos
     */
    protected function getContenidosMasVisitados($nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $contenido = new GconContenidos();
        $filtro = "Publish='1'";

        $rows = $contenido->cargaCondicion("Id", $filtro, "NumberVisits DESC {$limite}");

        foreach ($rows as $row) {
            $contenido = new GconContenidos($row['Id']);
            $array[] = array(
                'titulo' => $contenido->getTitulo(),
                'url' => $contenido->getObjetoUrlAmigable()->getHref(),
            );
        }
        unset($contenido);

        return $array;
    }

    /**
     * Devuelve un array con contenidos que son EVENTOS.
     * 
     * Los contenidos que se devuelven deben estar marcados con EVENTO,
     * tener asignados fechas de evento y estar marcados com publicados.
     * 
     * Están ordenados DESCENDENTEMENTE por Fecha y Hora de inicio
     * 
     * El array tiene 8 elementos:
     * 
     * - fecha => la fecha del evento
     * - horaInicio => la hora de inicio del evento
     * - horaFin => La hora de finalización del evento
     * - titulo => el titulo del evento
     * - subtitulo => el subtitulo del evento
     * - url => array(url => texto, targetBlank => boolean)
     * - resumen => el texto resumen del evento
     * - desarrollo => el texto desarrollado del evento
     * - imagen => Path de la imagen de diseño 1
     * 
     * @param date $desdeFecha La fecha en formato aaaa-mm-dd a partir desde la que se muestran los eventos. Opcional. Defecto hoy
     * @param integer $nItems El numero máximo de elementos a devolver. (0=todos)
     * @return array Array con los eventos
     */
    protected function getEventos($desdeFecha = '', $nItems = 0) {

        $array = array();

        if ($desdeFecha == "")
            $desdeFecha = date('Y-m-d');

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $evento = new EvenEventos();
        $filtro = "Fecha>='{$desdeFecha}'";

        $rows = $evento->cargaCondicion("Entidad,IdEntidad,Fecha,HoraInicio,HoraFin", $filtro, "Fecha DESC, HoraInicio DESC {$limite}");
        unset($evento);

        foreach ($rows as $row) {
            $evento = new $row['Entidad']($row['IdEntidad']);
            if ($evento->getPublish()->getIdTipo() == '1') {
                $documentos = $evento->getDocuments('image1');
                $imagen = ($documentos[0]) ? $documentos[0]->getPathName() : "";
                $array[] = array(
                    'fecha' => $row['Fecha'],
                    'horaInicio' => $row['HoraInicio'],
                    'horaFin' => $row['HoraFin'],
                    'titulo' => $evento->getTitulo(),
                    'subtitulo' => $evento->getSubtitulo(),
                    'url' => $evento->getObjetoUrlAmigable()->getHref(),
                    'resumen' => $this->limpiaTiny($evento->getResumen()),
                    'desarrollo' => $this->limpiaTiny($evento->getDesarrollo()),
                    'imagen' => $imagen,
                );
            }
        }
        unset($evento);
        unset($documentos);

        return $array;
    }

    /**
     * Devuelve un array con contenidos que son NOVEDADES.
     * 
     * Están ordenados DESCENDENTEMENTE por Id
     * 
     * El array tiene 5 elementos:
     * 
     * - titulo => el titulo de la novedad
     * - subtitulo => el subtitulo de la novedad
     * - resumen => el resumen de la novedad
     * - desarrollo => el desarrollo de la novedad
     * - url => array(url => texto, targetBlank => boolean)
     * 
     * @param integer $nItems Número máximo de novedades a devolver. Opcional (defecto=5)
     * @return array Array de novedades
     */
    protected function getNovedades($nItems = 5) {

        $array = array();
        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        $novedad = new GconContenidos();
        $filtro = "NoticiaPublicar='1' AND NoticiaPublicarEnPortada='1' AND Publish='1'";

        $rows = $novedad->cargaCondicion("Id", $filtro, "Id DESC {$limite}");
        unset($novedad);

        foreach ($rows as $row) {
            $novedad = new GconContenidos($row['Id']);
            $array[] = array(
                'titulo' => $novedad->getTitulo(),
                'subtitulo' => $novedad->getSubtitulo(),
                'resumen' => $this->limpiaTiny($novedad->getResumen()),
                'desarrollo' => $this->limpiaTiny($novedad->getDesarrollo()),
                'url' => $novedad->getHref(),
            );
        }
        unset($novedad);

        return $array;
    }

    /**
     * Devuelve un array con SLIDERS.
     * 
     * Están ordenados ASCEDENTEMENTE por Id.
     * 
     * Si el registro de slider existe pero no tiene imagen de diseño 1
     * o, teniéndola no está marcada publicar, no se tendrá en cuenta.
     * 
     * El array tiene 5 elementos:
     * 
     * - titulo => el titulo dl slider
     * - subtitulo => el subtitulo del slider
     * - resumen => el resumen del slider si MostrarTextos = TRUE
     * - url => array(url => texto, targetBlank => boolean)
     * - imagen => Path de la imagen de diseño 1
     * 
     * @param int $idZona La zona de slider a filtrar. Opcional. Defecto = 1
     * @param int $tipo El tipo de sliders. Valores posibles en entities/abstract/TiposSliders.class.php
     * @param int $nItems Número máximo de sliders a devolver. Opcional. Defecto todos
     * @return array Array de sliders
     */
    protected function getSliders($idZona = 1, $tipo = 0, $nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT 0,{$nItems}";

        // Valido el tipo de slider. Si no es correcto lo pongo a tipo 0 (variable)
        $tipoSlider = new TiposSliders($tipo);
        if ($tipoSlider->getIDTipo() == null)
            $tipo = 0;

        $slider = new SldSliders();
        $filtro = "IdZona='{$idZona}' AND IdTipo='{$tipoSlider}' AND Publish='1'";
        $rows = $slider->cargaCondicion("Id", $filtro, "Id ASC {$limite}");
        unset($slider);

        foreach ($rows as $row) {
            $slider = new SldSliders($row['Id']);
            $documentos = $slider->getDocuments('image1');
            $imagen = ($documentos[0]) ? $documentos[0]->getPathName() : "";

            // No se tiene en cuenta los sliders que no tienen imagen de diseño 1
            if ($imagen) {

                if ($slider->getMostrarTextos()->getIDTipo() == '0') {
                    $titulo = '';
                    $subtitulo = '';
                    $resumen = '';
                } else {
                    $titulo = $slider->getTitulo();
                    $subtitulo = $slider->getSubtitulo();
                    $resumen = $slider->getResumen();
                }

                $array[] = array(
                    'titulo' => $titulo,
                    'subtitulo' => $subtitulo,
                    'resumen' => $resumen,
                    'url' => $slider->getHref(),
                    'imagen' => $imagen,
                );
            }
        }
        unset($slider);
        unset($documentos);

        return $array;
    }

    /**
     * Devuelve un array con álbumes fotográficos
     * 
     * En el array habrá tantos elementos como álbumes devueltos.
     * 
     * Cada uno de estos elementos tiene la siguiente estructura:
     * 
     * - Titulo => el título del álbum
     * - bloqueThumbnail => array(
     *      0 => array( 
     *              PathName => el path de la imagen
     *              Title => el titulo de la imagen (si ShowCaption = TRUE)
     *              PathNameThumbnail => el path del thumbnail
     *          )
     *      ....
     * )
     * - restosImagenes => array(
     *      0 => array( 
     *              PathName => el path de la imagen
     *              Title => el titulo de la imagen (si ShowCaption = TRUE)
     *              PathNameThumbnail => el path del thumbnail
     *          )
     *      ....
     *           
     * @param int $portada Si es menor a 0 se muestran los de SI portada y los de No portada.
     * Si es 0 se muestran solo los de NO portada. Si es mayor que 0 se muestran solo los de SI portada. Por defecto 1
     * @param int $idSeccion El id de la sección de álbumes. Un valor menor o igual a 0 indica todas las secciones. Por defecto todas (0)
     * @param int $nAlbumes El número de álbumes a devolver. Por defecto 1
     * @param int $nImagenes El número de imágenes que compondrá el bloque 'bloqueThumbnail'. Si hubiese más, el resto estarán en el bloque 'restoImagenes'. Por defecto 1
     * @return type
     */
    protected function getAlbumes($portada = 1, $idSeccion = 0, $nAlbumes = 1, $nImagenes = 1) {

        if ($nAlbumes <= 0)
            $nAlbumes = 9999;
        if ($nImagenes <= 0)
            $nImagenes = 9999;

        $filtro = ($idSeccion <= 0) ? "(1)" : "(IdSeccion='{$idSeccion}')";

        if ($portada) {
            $filtro .= " AND (MostrarEnPortada='1')";
            $orden = "OrdenPortada ASC";
        } else
            $orden = "SortOrder ASC";

        $album = new AlbmAlbumes();
        $rows = $album->cargaCondicion("Id,Titulo", $filtro, "{$orden} limit {$nAlbumes}");
        unset($album);

        foreach ($rows as $key => $row) {
            $rows[$key]['bloqueThumbnail'] = $this->getGaleria('AlbmAlbumes', $row['Id'], 0, $nImagenes);
            $rows[$key]['restoImagenes'] = $this->getGaleria('AlbmAlbumes', $row['Id'], $nImagenes);
            unset($rows[$key]['Id']);
        }

        return $rows;
    }

    /**
     * 
     * @param type $entidad
     * @param type $idEntidad
     * @param int $posicionInicio
     * @param int $nImagenes
     * @return array
     */
    protected function getGaleria($entidad, $idEntidad, $posicionInicio = 0, $nImagenes = 999999) {

        if ($posicionInicio < 0) $posicionInicio = 0;
        if ($nImagenes <= 0) $nImagenes = 999999;
        
        $limite = "{$posicionInicio},{$nImagenes}";
        
        $dcto = new CpanDocs();
        $rows = $dcto->cargaCondicion("Id,PathName,Title,ShowCaption", "Entity='{$entidad}' and IdEntity='{$idEntidad}' and Type='galery' and IsThumbnail='0'", "SortOrder ASC limit {$limite}");

        foreach ($rows as $key => $row) {
            $thumbnail = $dcto->cargaCondicion("PathName", "BelongsTo='{$row['Id']}'");
            $rows[$key]['PathNameThumbnail'] = $thumbnail[0]['PathName'];
            if (!$row['ShowCaption'])
                unset($rows[$key]['Title']);
            unset($rows[$key]['Id']);
            unset($rows[$key]['ShowCaption']);
        }
        unset($dcto);

        return $rows;
    }

    /**
     * Devuelve el texto utilizado para calcular la password
     * 
     * El texto está en el nodo <config><semillaMD5> del archivo config/config.yml
     * 
     * @return string La semilla
     */
    protected function getSemilla() {

        $semilla = "";

        $fileConfig = $_SERVER['DOCUMENT_ROOT'] . $_SESSION['appPath'] . "/config/config.yml";

        if (file_exists($fileConfig)) {
            $yaml = sfYaml::load($fileConfig);
            $semilla = $yaml['config']['semillaMD5'];
        }

        return $semilla;
    }

    protected function limpiaTiny($textoTiny) {

        $texto = str_replace('<img src="' . $_SESSION['appUrl'] . '/', '<img src="', $textoTiny);
        return $texto;
    }

}

?>
