<?php

/**
 * Description of ControllerWeb
 *
 * Controlador común a todos los proyectos web
 *
 * @author Sergio Pérez
 * @copyright Informática ALBATRONIC, SL
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
     * Array con las variables Web
     * @var array
     */
    protected $varWeb;

    /**
     * Array con las variables Env
     * @var array
     */
    protected $varEnv;

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

        // Cargar las variables de entorno y web del proyecto en la variable 
        // de sesion y en $this->varEnv['Pro'] y $this->varWeb['Pro'] respectivamente
        // de esta forma solo se cargaran la primera vez
        $this->setVariables('Web', 'Pro');
        $this->setVariables('Env', 'Pro');

        // Establece los idiomas posibles de la web
        $this->values['LANGUAGES'] = $this->getIdiomasPermitidos();

        // CARGA LOS TEXTOS DE LAS ETIQUETAS WEB DEL IDIOMA CORRESPONDIENTE
        // La carga se realiza si no se ha hecho previamente o si estamos en
        // entorno de desarrollo
        $_SESSION['LABELS'] = $this->getEtiquetasIdioma($_SESSION['LANGUAGE']);

        //if (($_SESSION['LANGUAGE'] == '') or ($_SESSION['EntornoDesarrollo'])) {
        //    $_SESSION['LANGUAGE'] = $this->getIdioma();
        //    $_SESSION['LABELS'] = $this->getEtiquetasIdioma($_SESSION['LANGUAGE']);
        //}
        $this->values['LANGUAGE'] = $_SESSION['LANGUAGE'];
        $this->values['LABELS'] = $_SESSION['LABELS'];

        // CARGA LOS TEXTOS DE LOS PÁRRAFOS DEL CONTROLLER EN CURSO
        // CORRESPONDIENTES AL IDIOMA SELECCIONADO
        $this->values['TEXTS'] = $this->getTextosIdioma($_SESSION['LANGUAGE']);


        /**
         * CONTROL DE VISITAS, SI ESTÁ ACTIVO POR LA VARIABLE DE ENTORNO
         *
         * OBSOLETO: SE GESTIONA DESDE GOOGLE ANALYTICS

          if ($_SESSION['varEnv']['Pro']['visitas']['activo']) {

          // Borrar la tabla temporal de visitas, si procede según la
          // frecuencia de horas de borrado
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
          }
         * 
         */
        // LECTURA DE METATAGS
        $this->values['meta'] = $this->getMetaInformacion();

        // INCREMENTA EL NÚMERO DE VISITAS DE LA URL AMIGABLE Y SU ENTIDAD ASOCIADA
        $urlAmigable = new CpanUrlAmigables($this->request['IdUrlAmigable']);
        $urlAmigable->IncrementaVisitas();
        unset($urlAmigable);
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
     * Llena el array con las variables de entorno o web del proyecto o del módulo
     * 
     * @param string $tipo El tipo de las variables: Env, Web
     * @param string $ambito El ámbito de las variables: Pro ó Mod
     * @param string $modulo El nombre del modulo. Opcional. Por defecto el indicado en $this->request['Entity']
     */
    protected function setVariables($tipo, $ambito, $modulo = '') {

        if ($modulo == '')
            $modulo = $this->request['Entity'];

        switch ($tipo) {
            case 'Env':
                switch ($ambito) {
                    case 'Pro':
                        if (($_SESSION['EntornoDesarrollo']) or (!is_array($_SESSION['varEnv']['Pro']))) {
                            //$filtro = "IdProyectosApps='{$_SESSION['project']['Id']}' and Variable='varPro_Env'";
                            $filtro = "Variable='varPro_Env'";
                            $variables = new CpanVariables();
                            $rows = $variables->cargaCondicion('Yml', $filtro);
                            unset($variables);

                            $_SESSION['varEnv']['Pro'] = sfYaml::load($rows[0]['Yml']);
                        }
                        $this->varEnv['Pro'] = $_SESSION['varEnv']['Pro'];
                        break;
                }
                break;

            case 'Web':
                switch ($ambito) {
                    case 'Pro':
                        if (($_SESSION['EntornoDesarrollo']) or (!is_array($_SESSION['varWeb']['Pro']))) {
                            //$filtro = "IdProyectosApps='{$_SESSION['project']['Id']}' and Variable='varPro_Web'";
                            $filtro = "Variable='varPro_Web'";
                            $variables = new CpanVariables();
                            $rows = $variables->cargaCondicion('Yml', $filtro);
                            unset($variables);

                            $_SESSION['varWeb']['Pro'] = sfYaml::load($rows[0]['Yml']);
                        }
                        $this->varWeb['Pro'] = $_SESSION['varWeb']['Pro'];
                        break;

                    case 'Mod':
                        if (($_SESSION['EntornoDesarrollo']) or (!is_array($_SESSION['varWeb']['Mod'][$modulo]))) {
                            //$filtro = "IdProyectosApps='{$_SESSION['project']['Id']}' and Variable='varMod_{$modulo}_Web'";
                            $filtro = "Variable='varMod_{$modulo}_Web'";
                            $variables = new CpanVariables();
                            $rows = $variables->cargaCondicion('Yml', $filtro);
                            unset($variables);

                            $_SESSION['varWeb']['Mod'][$modulo] = sfYaml::load($rows[0]['Yml']);
                        }
                        $this->varWeb['Mod'][$modulo] = $_SESSION['varWeb']['Mod'][$modulo];
                        break;
                }
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

        if ($this->request['Entity'] == 'GconContenidos') {
            $contenido = new GconContenidos($this->request['IdEntity']);
            $idSeccion = $contenido->getIdSeccion()->getId();
            unset($contenido);
        } else {
            $idSeccion = $this->request['IdEntity'];
        }

        $seccion = new GconSecciones($idSeccion);
        if ($seccion->getBelongsTo()->getId() > 0) {
            $ruta = $seccion->getPadres();
            foreach ($ruta as $IdPadre) {
                $subSeccion = new GconSecciones($IdPadre);
                $array[] = array(
                    'nombre' => $subSeccion->getTitulo(),
                    'url' => $subSeccion->getHref(),
                );
            }
        } else {
            $array[] = array(
                'nombre' => 'Inicio',
                'url' => array('url' => $_SESSION['appPath'], 'targetBlank' => 0),
            );
        }

        $array[] = array(
            'nombre' => $seccion->getTitulo(),
            'url' => $seccion->getHref(),
        );

        unset($seccion);

        return $array;
    }

    /**
     * Devuelve un array con los parametros que definen una red social
     * 
     * Cada ocurrencia del array tiene los siguientes elementos:
     * 
     * - titulo : el titulo de la red social
     * - idUsuario: el id o login de la red social
     * - url: la url
     * - numeroItems: número de tweets/caras a mostrar
     * - mostrarAvatar: Booleano, mostrar o no el avatar
     * - mensaje: El mensaje para el caso que no haya tweets a mostrar
     * - botonEnviar: Booleano, mostrar o no el boton eviar
     * - modoMostar:
     * - font
     * - class
     * - action
     * - ancho
     * - alto
     * - size
     * - colorFondo
     * - colorBorde
     * - count
     * - imagen: path a la imagen de diseño 1
     * 
     * @param string $titulo El titulo de la red social por la que filtrar
     * @return array Array con la informacion de la red
     */
    protected function getRedSocial($titulo) {

        $redes = new Networking();
        $red = $redes->find("Titulo",$titulo);
        unset($redes);

        $array = array(
            'titulo' => $red->getTitulo(),
            'idUsuario' => $red->getIdUsuario(),
            'url' => $red->getUrl(),
            'numeroItems' => $red->getNumeroItems(),
            'mostrarAvatar' => $red->getMostrarAvatar()->getIdTipo(),
            'mensaje' => $red->getMensaje(),
            'botonEnviar' => $red->getBotonEnviar()->getIdTipo(),
            'modoMostar' => $red->getModoMostrar(),
            'font' => $red->getFont(),
            'class' => $red->getClass(),
            'action' => $red->getAction(),
            'ancho' => $red->getAncho(),
            'alto' => $red->getAlto(),
            'size' => $red->getSize(),
            'colorFondo' => $red->getColorFondo(),
            'colorBorde' => $red->getColorBorde(),
            'count' => $red->getCount(),
            'imagen' => $red->getPathNameImagenN(1),
        );

        unset($red);

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

        $array = array();

        if ($this->request['Entity'] == 'GconContenidos') {
            $contenido = new GconContenidos($this->request['IdEntity']);
            $idSeccion = $contenido->getIdSeccion()->getId();
            unset($contenido);
        } else {
            $idSeccion = $this->request['IdEntity'];
        }

        $seccion = new GconSecciones($idSeccion);
        $array['titulo'] = $seccion->getEtiquetaWeb1();

        $rows = $seccion->cargaCondicion("Id", "BelongsTo='{$seccion->getId()}'", "OrdenMenu1 ASC");
        foreach ($rows as $row) {
            $subSeccion = new GconSecciones($row['Id']);
            $array['subsecciones'][] = array(
                'titulo' => $subSeccion->getTitulo(),
                'subtitulo' => $subSeccion->getSubtitulo(),
                'EtiquetaWeb1' => $subSeccion->getEtiquetaWeb1(),
                'url' => $subSeccion->getHref(),
            );
        }
        $padre = $seccion->getBelongsTo();
        if ($padre->getId() > 0) {
            $url = $padre->getHref();
            $array['subirNivel'] = $url['url'];
        }

        unset($seccion);
        unset($padre);

        return $array;
    }

    /**
     * Genera el array del menu indicado en $nMenu en base a las SECCIONES que:
     * 
     *      MostrarEnMenuN = 1
     * 
     * Los elementos del array son:
     * 
     * - etiquetaWeb => texto de la etiquetaWebN
     * - subetiquetaWeb => texto de la subetiquetaWebN
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

        if (($nMenu < 1) or ($nMenu > 5))
            $nMenu = 1;
        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $seccion = new GconSecciones();
        $filtro = "MostrarEnMenu{$nMenu}='1'";
        $rows = $seccion->cargaCondicion("Id", $filtro, "OrdenMenu{$nMenu} ASC {$limite}");

        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $array[] = array(
                'etiquetaWeb' => $seccion->{"getEtiquetaWeb$nMenu"}(),
                'subetiquetaWeb' => $seccion->{"getSubetiquetaWeb$nMenu"}(),
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
     *      MostrarEnMenuN = 1
     *      BelongsTo = 0
     * 
     * Los elementos del array son:
     * 
     * - seccion => texto de la etiquetaWebN
     * - subetiquetaWeb => texto de la subetiquetaWebN
     * - url => array(url => texto, targetBlank => boolean)
     * - subsecciones => array de 0 a N (
     *                          titulo => texto
     *                          url => array(url => texto, targetBlank => boolean)
     *                      )
     *
     * @param int $nMenu El número de menu a mostrar (de 1 a 5). Por defecto 2
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional. (0=todos)
     * @return array Array con las secciones
     */
    protected function getMenuDesplegable($nMenu = 2, $nItems = 0) {

        $array = array();

        if (($nMenu < 1) or ($nMenu > 5))
            $nMenu = 2;
        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $menu = new GconSecciones();
        $filtro = "MostrarEnMenu{$nMenu}='1' AND BelongsTo='0'";
        $rows = $menu->cargaCondicion("Id", $filtro, "OrdenMenu{$nMenu} ASC {$limite}");
        unset($menu);

        foreach ($rows as $row) {
            $subseccion = new GconSecciones($row['Id']);

            $array[] = array(
                'seccion' => $subseccion->{"getEtiquetaWeb$nMenu"}(),
                'subetiquetaWeb' => $subseccion->{"getSubetiquetaWeb$nMenu"}(),
                'url' => $subseccion->getHref(),
                'subsecciones' => $subseccion->getArraySubsecciones("OrdenMenu{$nMenu}", $nMenu),
            );
        }
        unset($subseccion);

        return $array;
    }

    /**
     * Devuelve un array con las columnas del objeto $entidad cuyo id es $idEntidad
     * indicadas en el array $arrayColumnas.
     * 
     * Si no se indica $arrayColumnas, devuelve el OBJETO completo
     * 
     * Además añade al array devuelto el elemento 'url'
     * 
     * @param string $entidad El nombre de la entidad
     * @param int $idEntidad El id del objeto
     * @param array $arrayColumnas Array con las columnas. Opcional
     * @return mixed Array con las columnas del objeto o el objeto completo
     */
    protected function getObjeto($entidad, $idEntidad, $arrayColumnas = '') {

        $objeto = new $entidad($idEntidad);

        if (is_array($arrayColumnas)) {
            $array = array();

            $array['url'] = $objeto->getHref();

            foreach ($arrayColumnas as $columna) {
                $array[$columna] = $objeto->{"get$columna"}();
            }

            return $array;
        } else
            return $objeto;
    }

    /**
     * Devuelve el objeto contenido cuyo id es $idContenido, o
     * un array con las columnas indicadas en $arrayColumnas
     * 
     * Este método existe por compatibilidad con otras versiones. Lo correcto
     * es usar el método más genérico 'getObjeto'
     * 
     * @param type $idContenido
     * @param type $arrayColumnas
     * @return type
     */
    protected function getContenido($idContenido, $arrayColumnas = '') {
        return $this->getObjeto('GconContenidos', $idContenido, $arrayColumnas);
    }
    
    /**
     * Devuelve un array de objetos contenidos correspondientes
     * a la sección $idSeccion
     * 
     * @param integer $idSeccion El id de la sección de contenidos
     * @return array Array \GconContenidos
     */
    protected function getContenidosSeccion($idSeccion) {

        $array = array();

        $contenidos = new GconContenidos();
        $rows = $contenidos->cargaCondicion("Id", "IdSeccion='{$idSeccion}'");
        unset($contenidos);

        foreach ($rows as $row) {
            $array[] = new GconContenidos($row['Id']);
        }

        return $array;
    }

    /**
     * Devuelve un array con la información del contenido desarrollado
     * 
     * El array tiene los elementos:
     * 
     * - contenido: El OBJETO contenido
     * - galeriaFotos: Array con la galeria de fotos
     * - enlacesRelacionados: Array de enlaces relacionados
     * 
     * @param int $idContenido El id del contenido
     * @param int $nImagenes Numero de imágenes que van en la galeria de fotos
     * @return array Array con el contenido desarrollado
     */
    protected function getContenidoDesarrollado($idContenido, $nImagenes = 99999) {

        if ($nImagenes <= 0)
            $nImagenes = 99999;

        $contenido = new GconContenidos($idContenido);
        
        return array(
            'contenido' => $this->getObjeto('GconContenidos',$idContenido),
            'galeriaFotos' => $this->getAlbumExterno('GconContenidos', $idContenido, $nImagenes),
            'enlacesRelacionados' => $this->getEnlacesRelacionados('GconContenidos', $idContenido),
            'videos' => $this->getVideos($contenido->getIDSeccionVideos()->getId(),-1),
        );
    }

    /**
     * Genera el array con las noticias en base a los CONTENIDOS que:
     * 
     *      NoticiaPublicar = 1
     * 
     * Si las noticias a devolver son las de portada, además se tiene en cuenta
     * las variables web del módulo GconContenidos:
     * 
     * - NumNoticasMostrarHome, y
     * - NumNoticasPorPagina
     * 
     * El array tiene los siguientes elementos
     * 
     * - rows. Con n elementos de la forma:
     *   - fecha => la fecha de publicación (PublisehAt)
     *   - titulo => titulo de la noticia
     *   - subtitulo => subtitulo de la noticia
     *   - url => array(url => texto, targetBlank => boolean)
     *   - resumen => texto del resumen
     *   - desarrollo => texto del desarrollo
     *   - imagen => Path de la imagen de diseño 1
     * - pagina => El número de la página actual
     * - numeroPaginas => El número total de páginas
     * - numeroTotalItems => El número total de noticias
     * 
     * @param boolean $enPortada Si TRUE se devuelven solo las que están marcadas como portada, 
     * en caso contrario se devuelven todas las noticias
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional.
     * Si no se indica valor, se mostrará el número de noticias indicado en las variables
     * web 'NumNoticasMostrarHome' o 'NumNoticasPorPagina' dependiendo de $enPortada
     * @param int $nPagina El número de la página. Opcional. Por defecto la primera
     * @param integer $nImagenDiseno El número de la imagen de diseño. Por defecto la primera
     * @return array Array con las noticias
     */
    protected function getNoticias($enPortada = true, $nItems = 0, $nPagina = 1, $nImagenDiseno = 1) {

        $this->setVariables('Web', 'Mod', 'GconContenidos');

        if ($nItems <= 0) {
            $nItems = ($enPortada) ?
                    $this->varWeb['Mod']['GconContenidos']['especificas']['NumNoticiasHome'] :
                    $this->varWeb['Mod']['GconContenidos']['especificas']['NumNoticiasPorPagina'];
        }

        if ($nPagina <= 0)
            $nPagina = 1;

        $filtro = "NoticiaPublicar='1'";
        if ($enPortada)
            $filtro .= " AND NoticiaMostrarEnPortada='{$enPortada}'";
        $criterioOrden = $this->varWeb['Mod']['GconContenidos']['especificas']['CriterioOrdenNoticias'];

        Paginacion::paginar("GconContenidos", $filtro, $criterioOrden, $nPagina, $nItems);

        foreach (Paginacion::getRows() as $row) {
            $noticia = new GconContenidos($row['Id']);
            $paginacion['rows'][] = array(
                'fecha' => $noticia->getPublishedAt(),
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getHref(),
                'resumen' => $this->limpiaTiny($noticia->getResumen()),
                'desarrollo' => $this->limpiaTiny($noticia->getDesarrollo()),
                'imagen' => $noticia->getPathNameImagenN($nImagenDiseno),
            );
        }
        unset($noticia);

        $paginacion['paginacion'] = Paginacion::getPaginacion();

        return $paginacion;
    }

    /**
     * Genera el array con las noticias más leidas
     * 
     * Las noticias son Contenidos que tienen a TRUE el campo NoticiaPublicar
     * 
     * Las noticias se ordenan descendentemente por número de visitas (NumberVisits)
     * 
     * Si no se indica el parámetro $nItems, se buscará el valor de la variable
     * web 'NumNoticasMostrarHome'
     * 
     * El array los siguientes elementos:
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
     * Si no se indica valor, se mostrarán las indicadas en la VW 'NumNoticasHome'
     * @param integer $nImagenDiseno El número de la imagen de diseño. Por defecto la primera
     * @return array Array con las noticias
     */
    protected function getNoticiasMasLeidas($nItems = 0, $nImagenDiseno = 1) {

        $array = array();

        if ($nItems <= 0) {
            $this->setVariables('Web', 'Mod', 'GconContenidos');
            $nItems = $this->varWeb['Mod']['GconContenidos']['especificas']['NumNoticiasHome'];
        }
        $orden = $this->varWeb['Mod']['GconContenidos']['especificas']['CriterioOrdenNoticias'];
        
        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $noticia = new GconContenidos();
        $filtro = "NoticiaPublicar='1'";

        $rows = $noticia->cargaCondicion("Id", $filtro, "{$orden} {$limite}");

        foreach ($rows as $row) {
            $noticia = new GconContenidos($row['Id']);
            $array[] = array(
                'fecha' => $noticia->getPublishedAt(),
                'titulo' => $noticia->getTitulo(),
                'subtitulo' => $noticia->getSubtitulo(),
                'url' => $noticia->getHref(),
                'resumen' => $this->limpiaTiny($noticia->getResumen()),
                'desarrollo' => $this->limpiaTiny($noticia->getDesarrollo()),
                'imagen' => $noticia->getPathNameImagenN($nImagenDiseno),
            );
        }
        unset($noticia);

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

        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $contenido = new GconContenidos();

        $rows = $contenido->cargaCondicion("Id", "", "NumberVisits DESC {$limite}");

        foreach ($rows as $row) {
            $contenido = new GconContenidos($row['Id']);
            $array[] = array(
                'titulo' => $contenido->getTitulo(),
                'url' => $contenido->getHref(),
            );
        }
        unset($contenido);

        return $array;
    }

    /**
     * Devuelve un array con contenidos que son EVENTOS.
     * 
     * Los contenidos que se devuelven deben estar marcados con EVENTO,
     * tener asignados fechas de evento y estar marcados como publicados.
     * 
     * Están ordenados ASCENDENTEMENTE por Fecha y Hora de inicio
     * 
     * El array tiene los siguientes elementos:
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
     * @param date $hastaFecha La fecha en formato aaaa-mm-dd hasta cuando se muestran los eventos. Opcional. Defecto sin límite
     * @param integer $nItems El numero máximo de elementos a devolver. (0=todos)
     * @param integer $nImagenDiseno El número de la imagen de diseño. Por defecto la primera
     * @param boolean $unicos Si TRUE solo se devuelven los eventos únicos
     * @return array Array con los eventos
     */
    protected function getEventos($desdeFecha = '', $hastaFecha = '', $nItems = 0, $nImagenDiseno = 1, $unicos = 1) {

        $array = array();

        if ($desdeFecha == "")
            $desdeFecha = date('Y-m-d');

        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $evento = new EvenEventos();
        $filtro = "Fecha>='{$desdeFecha}'";
        if ($hastaFecha != "")
            $filtro .= " AND Fecha<='{$hastaFecha}'";
        //echo $filtro,"<br/>";
            
        $rows = $evento->cargaCondicion("Entidad,IdEntidad,Fecha,HoraInicio,HoraFin", $filtro, "Fecha ASC, HoraInicio ASC {$limite}");
        unset($evento);

        $eventos = array();
        if ($unicos) {
            foreach ($rows as $row)
                if (!isset($eventos[$row['Entidad'] . $row['IdEntidad']]))
                    $eventos[$row['Entidad'] . $row['IdEntidad']] = $row;
        } else {
            $eventos = $rows;
        }

        $hoy = date('Y/m/d');

        foreach ($eventos as $row) {
            $evento = new $row['Entidad']($row['IdEntidad']);
            if ( ($evento->getPublish()->getIdTipo() == '1') && ($evento->getActiveFrom('aaaammdd')<=$hoy) && ( ($evento->getActiveTo('aaaammdd') == '0000/00/00') or ($evento->getActiveTo('aaaammdd')>=$hoy)) ) {
                $array[] = array(
                    'fecha' => $row['Fecha'],
                    'horaInicio' => $row['HoraInicio'],
                    'horaFin' => $row['HoraFin'],
                    'titulo' => $evento->getTitulo(),
                    'subtitulo' => $evento->getSubtitulo(),
                    'url' => $evento->getHref(),
                    'resumen' => $this->limpiaTiny($evento->getResumen()),
                    'desarrollo' => $this->limpiaTiny($evento->getDesarrollo()),
                    'imagen' => $evento->getPathNameImagenN($nImagenDiseno),
                );
            }
        }
        unset($evento);

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
        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        $novedad = new GconContenidos();
        $filtro = "NoticiaPublicar='1' AND NoticiaPublicarEnPortada='1'";

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
     * Genera el array con los articulos del blog en base a los CONTENIDOS que:
     * 
     *      BlogPublicar = 1
     * 
     * Si los articulos a devolver son los de portada, además se tiene en cuenta
     * las variables web del módulo GconContenidos:
     * 
     * - NumArticulosBlogHome, y
     * - NumArticulosBlogPorPagina
     * 
     * El array tiene dos elementos:
     * 
     * - secciones => array:
     * 
     *      - titulo => el título de la sección
     *      - url => array(url => texto, targetBlank => boolean) 
     *      - nArticulos =>
     * 
     * - articulos => array:
     * 
     *      - fecha => la fecha de publicación (PublisehAt)
     *      - titulo => titulo de la noticia
     *      - subtitulo => subtitulo de la noticia
     *      - url => array(url => texto, targetBlank => boolean)
     *      - resumen => texto del resumen
     *      - desarrollo => texto del desarrollo
     *      - imagen => Path de la imagen de diseño 1
     * 
     * @param boolean $enPortada Si TRUE se devuelven solo los que están marcados como portada, 
     * en caso contrario se devuelven todas los articulos
     * @param integer $nItems El numero máximo de elementos a devolver. Opcional.
     * Si no se indica valor, se mostrará el número de articulos indicado en las variables
     * web 'NumArticulosBlogHome' o 'NumArticulosBlogPorPagina' dependiendo de $enPortada
     * @param integer $nImagenDiseno El número de la imagen de diseño. Por defecto la primera
     * @return array Array con las noticias
     */
    protected function getArticulosBlog($enPortada = true, $nItems = 0, $nImagenDiseno = 1) {

        $arraySecciones = array();
        $arrayArticulos = array();

        $this->setVariables('Web', 'Mod', 'GconContenidos');

        if ($nItems <= 0) {
            $nItems = ($enPortada) ?
                    $this->varWeb['Mod']['GconContenidos']['especificas']['NumArticulosBlogHome'] :
                    $this->varWeb['Mod']['GconContenidos']['especificas']['NumArticulosBlogPorPagina'];
        }

        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";
        $filtro = "BlogPublicar='1'";
        if ($enPortada)
            $filtro .= " AND BlogMostrarEnPortada='{$enPortada}'";
        //$criterioOrden = $this->varWeb['Mod']['GconContenidos']['CriterioOrdenNoticias'];
        $criterioOrden = "PublishedAt DESC";

        $articulo = new GconContenidos();

        $rows = $articulo->cargaCondicion("Id", $filtro, "{$criterioOrden} {$limite}");

        foreach ($rows as $row) {
            $articulo = new GconContenidos($row['Id']);

            $seccion = $articulo->getIdSeccion();
            if (!isset($arraySecciones[$seccion->getId()])) {
                $arraySecciones[$seccion->getId()] = array(
                    'titulo' => $seccion->getTitulo(),
                    'url' => $seccion->getHref(),
                    'nArticulos' => $seccion->getNumberOfContenidos(),
                );
            }

            $arrayArticulos[] = array(
                'seccion' => $seccion->getTitulo(),
                'fecha' => $articulo->getPublishedAt(),
                'titulo' => $articulo->getTitulo(),
                'subtitulo' => $articulo->getSubtitulo(),
                'url' => $articulo->getHref(),
                'resumen' => $this->limpiaTiny($articulo->getResumen()),
                'desarrollo' => $this->limpiaTiny($articulo->getDesarrollo()),
                'imagen' => $articulo->getPathNameImagenN($nImagenDiseno),
            );
            unset($seccion);
        }
        unset($articulo);

        asort($arraySecciones);

        return array(
            'secciones' => $arraySecciones,
            'articulos' => $arrayArticulos,
        );
    }

    protected function getArticulosBlogMes($nMeses = 6) {

        $array = array();

        if ($nMeses <= 0)
            $nMeses = 6;

        $limite = "LIMIT {$nMeses}";

        $filtro = "BlogPublicar='1'";

        $criterioOrden = "anio DESC, mes DESC";
        $articulo = new GconContenidos();
        $rows = $articulo->cargaCondicion("YEAR(PublishedAt) as anio, MONTH(PublishedAt) as mes, COUNT(Id) as nArticulos", "{$filtro} GROUP BY anio, mes", "{$criterioOrden} {$limite}");
        unset($articulo);

        foreach ($rows as $row) {
            $mes = new Meses($row['mes']);
            $array[] = array(
                'anio' => $row['anio'],
                'numeroMes' => $row['mes'],
                'textoMes' => $mes->getDescripcion(),
                'nArticulos' => $row['nArticulos'],
            );
        }

        unset($mes);

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
     * - titulo => el titulo del slider
     * - subtitulo => el subtitulo del slider
     * - resumen => el resumen del slider si MostrarTextos = TRUE
     * - url => array(url => texto, targetBlank => boolean)
     * - imagen => Path de la imagen de diseño 1
     * 
     * @param int $idZona El id de la zona de slider a filtrar. Opcional. Defecto la primera que encuentre
     * @param int $tipo El tipo de sliders. Opcional. Por defecto el tipo 0. Valores posibles en entities/abstract/TiposSliders.class.php
     * @param int $nItems Número máximo de sliders a devolver. Opcional. Defecto todos
     * @return array Array de sliders
     */
    protected function getSliders($idZona = '*', $tipo = 0, $nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        // Valido el tipo de slider. Si no es correcto lo pongo a tipo 0 (variable)
        $tipoSlider = new TiposSliders($tipo);
        if ($tipoSlider->getIDTipo() == null)
            $tipo = 0;

        $filtro = ($idZona == '*') ? "(1)" : "IdZona='{$idZona}'";
        $filtro .= " AND IdTipo='{$tipo}'";

        $slider = new SldSliders();

        $rows = $slider->cargaCondicion("Id", $filtro, "SortOrder ASC {$limite}");
        unset($slider);

        foreach ($rows as $row) {
            $slider = new SldSliders($row['Id']);
            $imagen = $slider->getPathNameImagenN(1);

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

        return $array;
    }

    /**
     * Devuelve un array con BANNERS.
     * 
     * Están ordenados ASCEDENTEMENTE por Id u OrdenMostrarEnListado en el caso
     * que se vayan a devolver solo los que sean mostrarEnListado TRUE.
     * 
     * Si el registro de banner existe pero no tiene imagenes, o
     * teniéndolas no están marcadas publicar, no se tendrá en cuenta.
     * 
     * El array tiene 5 elementos:
     * 
     * - titulo => el titulo del banner
     * - subtitulo => el subtitulo del banner
     * - resumen => el resumen del banner
     * - url => array(url => texto, targetBlank => boolean)
     * - imagenes => array con los paths de las imágenes
     * 
     * @param int $idZona El id de la zona de banner a filtrar. Opcional. Defecto la primera que encuentre.
     * @param int $tipo El tipo de banner. Un valor negativo significa todos los tipos. Por defecto 0 (fijo). Valores posibles en entities/abstract/TiposBanners.class.php
     * @param boolean $mostrarEnListado Un valor negativo para todos, 0 para los NO y 1 para los SI mostrar en listado
     * @param int $nItems Número máximo de banners a devolver. Opcional. Defecto todos
     * @return array Array de banners
     */
    protected function getBanners($idZona = '*', $tipo = 0, $mostrarEnListado = 0, $nItems = 0) {

        $array = array();

        $limite = ($nItems <= 0) ? "" : "LIMIT {$nItems}";

        // Valido el tipo de banner. Si no es correcto lo pongo a tipo 0 (fijo)
        if ($tipo < 0)
            $filtroTipo = "(1)";
        else {
            $tipoBanner = new TiposBanners($tipo);
            if ($tipoBanner->getIDTipo() == null)
                $tipo = 0;
            $filtroTipo = "(IdTipo='{$tipo}')";
        }

        // Filtro Zona
        $filtroZona = ($idZona == '*') ? "(1)" : "IdZona='{$idZona}'";

        // Filtro de 'mostrarEnListado'
        $filtroMostrarEnListado = ($mostrarEnListado < 0) ? "(1)" : "MostrarEnListado='{$mostrarEnListado}'";

        // Criterio de orden
        $orden = ($mostrarEnListado) ? "OrdenMostrarEnListado ASC" : "Id ASC";

        $filtro = "{$filtroZona} AND {$filtroTipo} AND {$filtroMostrarEnListado}";

        $banner = new BannBanners();

        $rows = $banner->cargaCondicion("Id", $filtro, "{$orden} {$limite}");
        unset($banner);

        foreach ($rows as $row) {
            $banner = new BannBanners($row['Id']);
            $documentos = $banner->getDocuments('image%');

            $imagenes = array();
            foreach ($documentos as $documento)
                $imagenes[] = $documento->getPathName();

            // No se tiene en cuenta los banners que no tienen imagenes
            if (count($imagenes)) {
                $array[] = array(
                    'titulo' => $banner->getTitulo(),
                    'subtitulo' => $banner->getSubtitulo(),
                    'resumen' => $banner->getResumen(),
                    'url' => $banner->getHref(),
                    'imagenes' => $imagenes,
                );
            }
        }
        unset($banner);
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
     * - titulo => el título del álbum
     * - subtitulo => el subtitulo del álbum
     * - resumen => el resumen del álbum
     * - imagen => path a la imagen de diseño 1
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
     * @return array Array de álbumes fotográficos
     */
    protected function getAlbumes($portada = 1, $idSeccion = 0, $nAlbumes = 1, $nImagenes = 1) {

        $albumes = array();

        if ($nAlbumes <= 0)
            $nAlbumes = 999999;
        if ($nImagenes <= 0)
            $nImagenes = 999999;

        $filtro = ($idSeccion <= 0) ? "(1)" : "(IdSeccion='{$idSeccion}')";

        if ($portada > 0) {
            $filtro .= " AND (MostrarEnPortada='1')";
            $orden = "OrdenPortada ASC";
        } else
            $orden = "SortOrder ASC";

        $album = new AlbmAlbumes();
        $rows = $album->cargaCondicion("Id", $filtro, "{$orden} LIMIT {$nAlbumes}");
        unset($album);

        foreach ($rows as $key => $row) {
            $album = new AlbmAlbumes($row['Id']);

            $albumes[$key] = $this->getAlbum($row['Id'], $nImagenes);
            $albumes[$key]['titulo'] = $album->getTitulo();
            $albumes[$key]['subtitulo'] = $album->getSubtitulo();
            $albumes[$key]['resumen'] = $album->getResumen();
            $albumes[$key]['autor'] = $album->getAutor();
            $albumes[$key]['imagen'] = $album->getPathNameImagenN(1);
        }
        unset($album);

        return $albumes;
    }

    /**
     * Devuelve un array con las imágenes del albúm fotográfico EXTERNO asociado 
     * a la entidad $entidad e $idEntidad
     * 
     * @param string $entidad El nombre de la entidad
     * @param int $idEntidad El id de la entidad
     * @param int $nImagenes El número de imagenes a devolver. Por defecto todas.
     * @return array
     *  
     * @example Para obtener los 2 primeros álbumes externos del servicio cuyo
     * id es 3: getAlbumExterno('ServServicios',3,2)
     */
    protected function getAlbumExterno($entidad, $idEntidad, $nImagenes = 99999) {

        $array = array();

        if ($nImagenes <= 0)
            $nImagenes = 99999;

        $objeto = new $entidad($idEntidad);
        $albumExterno = $objeto->getIdAlbumExterno();
        if ($albumExterno->getId())
            $array = $this->getAlbum($albumExterno->getId(), $nImagenes);
        unset($objeto);

        return $array;
    }

    /**
     * Devuelve un array con las imágenes del album fotográfico $idAlbum
     * 
     * El array tiene dos elementos:
     * 
     * - bloqueThumbnail: array del tipo galeria
     * - restoImagenes: array del tipo galeria
     * 
     * En el primer elemento habrá tantas imágenes como las indicadas en $nImagenes.
     * Si el album tuviese más imágenes, estas estarán en el elemento "restoImagenes"
     * 
     * @param int $idAlbum El id del álbum fotográfico
     * @param int $nImagenes El número de imágenes a devolver. Por defecto todas
     * @return array
     */
    protected function getAlbum($idAlbum, $nImagenes = 99999) {

        $array = array();

        if ($nImagenes <= 0)
            $nImagenes = 99999;

        $array['bloqueThumbnail'] = $this->getGaleria('AlbmAlbumes', $idAlbum, 0, $nImagenes);
        $array['restoImagenes'] = $this->getGaleria('AlbmAlbumes', $idAlbum, $nImagenes);

        return $array;
    }

    /**
     * 
     * @param type $entidad
     * @param type $idEntidad
     * @param int $posicionInicio
     * @param int $nImagenes Número máximo de imágenes a devolver. Opcional (por defecto todas)
     * @return array
     */
    protected function getGaleria($entidad, $idEntidad, $posicionInicio = 0, $nImagenes = 999999) {

        if ($posicionInicio < 0)
            $posicionInicio = 0;
        $nImagenes = ($nImagenes <= 0) ? 999999 : $nImagenes;

        $limite = "{$posicionInicio},{$nImagenes}";

        $dcto = new CpanDocs();
        $rows = $dcto->cargaCondicion("Id,PathName,Title,ShowCaption", "Entity='{$entidad}' and IdEntity='{$idEntidad}' and Type='galery' and IsThumbnail='0'", "SortOrder ASC LIMIT {$limite}");

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
     * Devuelve un array con los enlaces de interes asociados
     * a la entidad $entidad e identidad $identidad
     * 
     * @param string $entidad El nombre de la entidad
     * @param int $idEntidad EL id de la entidad
     * @param int $nItems El número máximo de enlaces a devolver. Opcional (por defecto todos)
     * @return array El array de enlaces de interes
     * 
     * @example Para obtener los primeros 5 enlaces relacionados
     * del contenido cuyo id es 6: getEnlacesRelacionados('GonContenidos',6,5)
     */
    protected function getEnlacesRelacionados($entidad, $idEntidad, $nItems = 999999) {

        if ($nItems <= 0)
            $nItems = 999999;

        $objeto = new $entidad($idEntidad);
        $seccionEnlace = $objeto->getIDSeccionEnlaces();
        unset($objeto);

        $array = $this->getEnlacesDeInteres($seccionEnlace->getId(), $nItems);

        unset($seccionEnlace);

        return $array;
    }

    /**
     * Devuelve un array con los enlaces de interes de la
     * seccion de enlaces $idSeccion, con un máximo de $nItems enlaces
     * 
     * El array tiene dos elementos:
     * 
     * - seccion: array()
     * - enlaces: array()
     * 
     * Cada elemento del subarray 'seccion' es de la forma:
     *
     * - titulo: el titulo del enlace
     * - subtitulo: el subtitulo del enlace
     * - reusmen: el resumen del enlace
     * - url: array ('url'=>, targetBlank=> boolean)
     *  
     * Cada elemento del subarray 'enlaces' es de la forma:
     * 
     * - titulo: el titulo del enlace
     * - subtitulo: el subtitulo del enlace
     * - resumen: el resumen del enlace
     * - url: array ('url'=>, targetBlank=> boolean)
     * 
     * @param int $idSeccion El id de la seccion de enlaces de interes
     * @param int $nItems El número máximo de enlaces a devolver
     * @return array El array de enlaces de interes
     */
    protected function getEnlacesDeInteres($idSeccion, $nItems = 999999) {

        $array = array();

        if ($nItems <= 0)
            $nItems = 999999;

        $array['seccion'] = $this->getSecciondeEnlaces($idSeccion);

        $enlace = new EnlEnlaces();
        $rows = $enlace->cargaCondicion("Id", "IdSeccion='{$idSeccion}'", "SortOrder ASC LIMIT {$nItems}");

        foreach ($rows as $row) {
            $enlace = new EnlEnlaces($row['Id']);
            $array['enlaces'][] = array(
                'titulo' => $enlace->getTitulo(),
                'subtitulo' => $enlace->getSubtitulo(),
                'resumen' => $enlace->getResumen(),
                'url' => $enlace->getHref(),
                'documentos' => $enlace->getDocuments('document'),
            );
        }
        unset($enlace);

        return $array;
    }

    /**
     * Devuelve un array con las secciones de enlaces de interes con
     * un máximo de $nItems secciones
     * 
     * Cada elemento del array es de la forma:
     * 
     * - titulo: el titulo de la seccion
     * - subtitulo: el subtitulo de la seccion
     * - resumen: el resumen de la seccion
     * - url: array ('url'=>, targetBlank=> boolean)
     *  
     * @param int $nItems Número máximo de secciones a devolver
     * @return array Array de secciones de enlaces
     */
    protected function getSeccionesDeEnlaces($nItems = 999999) {

        $array = array();

        if ($nItems <= 0)
            $nItems = 999999;

        $seccion = new EnlSecciones();
        $rows = $seccion->cargaCondicion("Id", '', "SortOrder ASC LIMIT {$nItems}");
        unset($seccion);

        foreach ($rows as $row)
            $array[] = $this->getSecciondeEnlaces($row['Id']);

        return $array;
    }

    protected function getSecciondeEnlaces($idSeccion) {

        $seccion = new EnlSecciones($idSeccion);
        $array = array(
            'titulo' => $seccion->getTitulo(),
            'subtitulo' => $seccion->getSubtitulo(),
            'resumen' => $seccion->getResumen(),
            'url' => $seccion->getHref(),
        );
        unset($seccion);

        return $array;
    }

    /**
     * Devuelve un array con videos.
     * 
     * El array tiene los siguientes elementos:
     * 
     * - titulo
     * - subtitulo
     * - resumen
     * - autor
     * - tipoVideo: la descripcion del tipo
     * - imagen: el path a la imagen (caratula del video)
     * - urlVideo: el id del video
     * - url => array(url => url, targetBlank => boolean)
     * 
     * @param int $idSeccion El id de la seccion de videos. Si es <= 0 se muestran todas las secciones.
     * @param int $mostrarEnPortada Menor a 0 para todos, 0 para los NO portada, 1 para los SI portada
     * @param int $nItems Número máximo de videos a devolver. Por defecto todos.
     * @return array Array con los videos
     */
    protected function getVideos($idSeccion = 1, $mostrarEnPortada = 0, $nItems = 999999) {

        $filtroSeccion = ($idSeccion <= 0) ? "(1)" : "(IdSeccion='{$idSeccion}')";

        if ($mostrarEnPortada < 0)
            $filtroPortada = "(1)";
        else
            $filtroPortada = ($mostrarEnPortada == 0) ? "(MostrarEnPortada='0')" : "(MostrarEnPortada='1')";

        if ($nItems <= 0)
            $nItems = 999999;

        $filtro = "{$filtroSeccion} AND {$filtroPortada}";
        $orden = ($mostrarEnPortada > 0) ? "OrdenPortada ASC" : "SortOrder ASC";

        $video = new VidVideos();
        $rows = $video->cargaCondicion("Id", $filtro, $orden . " LIMIT {$nItems}");
        unset($video);

        $videos = array();

        foreach ($rows as $row) {
            $video = new VidVideos($row['Id']);

            $videos[] = array(
                'titulo' => $video->getTitulo(),
                'subtitulo' => $video->getSubtitulo(),
                'resumen' => $video->getResumen(),
                'autor' => $video->getAutor(),
                'tipoVideo' => $video->getIdTipo()->getDescripcion(),
                'imagen' => $video->getPathNameImagenN(1),
                'urlVideo' => $video->getUrlVideo(),
                'url' => $video->getHref(),
            );
        }

        unset($video);

        return $videos;
    }

    protected function getSubsecciones($idSeccion) {

        $array = array();

        $seccion = new GconSecciones($idSeccion);

        $array['titulo'] = ($seccion->getMostrarTitulo()->getIDTipo() == 1) ? $seccion->getTitulo() : "";
        $array['subtitulo'] = ($seccion->getMostrarSubtitulo()->getIDTipo() == 1) ? $seccion->getSubtitulo() : "";
        $array['introduccion'] = ($seccion->getMostrarIntroduccion()->getIDTipo() == 1) ? $seccion->getIntroduccion() : "";

        $rows = $seccion->cargaCondicion("Id", "BelongsTo='{$idSeccion}'", "SortOrder ASC");
        foreach ($rows as $row) {
            $seccion = new GconSecciones($row['Id']);
            $array['subsecciones'][] = array(
                'titulo' => ($seccion->getMostrarTitulo()->getIDTipo() == 1) ? $seccion->getTitulo() : "",
                'subtitulo' => ($seccion->getMostrarSubtitulo()->getIDTipo() == 1) ? $seccion->getSubtitulo() : "",
                'introduccion' => ($seccion->getMostrarIntroduccion()->getIDTipo() == 1) ? $seccion->getIntroduccion() : "",
                'fecha' => $seccion->getPublishedAt(),
                'url' => $seccion->getHref(),
            );
        }
        unset($seccion);

        return $array;
    }

    /**
     * Devuelve un array con objetos Servicios
     * 
     * @param int $idFamilia El id de la familia de servicios. Si es <= 0 se muestran todas las familias.
     * @param int $mostrarEnPortada Menor a 0 para todos, 0 para los NO portada, 1 para los SI portada
     * @param int $nItems Número máximo de servicios a devolver. Por defecto todos.
     * @return array Array con objetos servicios
     */
    protected function getServicios($idFamilia = 0, $mostrarEnPortada = 0, $nItems = 999999) {

        $filtroFamilia = ($idFamilia <= 0) ? "(1)" : "(IdFamilia='{$idFamilia}')";

        if ($mostrarEnPortada < 0)
            $filtroPortada = "(1)";
        else
            $filtroPortada = ($mostrarEnPortada == 0) ? "(MostrarPortada='0')" : "(MostrarPortada='1')";

        if ($nItems <= 0)
            $nItems = 999999;

        $filtro = "{$filtroFamilia} AND {$filtroPortada}";
        $orden = ($mostrarEnPortada > 0) ? "MostrarPortadaOrden ASC" : "SortOrder ASC";

        $servicio = new ServServicios();
        $rows = $servicio->cargaCondicion("Id", $filtro, $orden . " LIMIT {$nItems}");
        unset($servicio);

        $servicios = array();

        foreach ($rows as $row)
            $servicios[] = new ServServicios($row['Id']);

        return $servicios;
    }

    /**
     * Devuelve un array con la información del servicio desarrollado
     * 
     * El array tiene los elementos:
     * 
     * - servicio: El OBJETO servicio
     * - galeriaFotos: Array con la galeria de fotos
     * - enlacesRelacionados: Array de enlaces relacionados
     * 
     * @param int $idServicio El id del servicio
     * @param int $nImagenes Numero de imágenes que van en la galeria de fotos
     * @return array Array con el servicio desarrollado
     */
    protected function getServicioDesarrollado($idServicio, $nImagenes = 99999) {

        if ($nImagenes <= 0)
            $nImagenes = 99999;

        return array(
            'servicio' => new ServServicio($idServicio),
            'galeriaFotos' => $this->getAlbumExterno('ServServicios', $idServicio, $nImagenes),
            'enlacesRelacionados' => $this->getEnlacesRelacionados('ServServicios', $idServicio),
        );
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

    /**
     * Genera un array con la meta información en base
     * a la meta del objeto en curso, su padre (belongsTo) y la del proyecto
     * 
     * @return array Array con la meta información
     */
    protected function getMetaInformacion() {

        $meta['pro'] = $this->varWeb['Pro']['meta'];

        $objetoActual = new $this->request['Entity']($this->request['IdEntity']);
        $meta['objetoActual'] = array(
            'title' => $objetoActual->getMetatagTitle(),
            'description' => $objetoActual->getMetatagDescription(),
            'keyWords' => $objetoActual->getMetatagKeywords(),
            'titleSimple' => $objetoActual->getMetatagTitleSimple()->getIDTipo(),
            'titlePosition' => $objetoActual->getMetatagTitlePosition()->getIDTipo(),
            'revisitAfter' => $objetoActual->getRevisitAfter(),
        );
        
        $objetoPadre = $objetoActual->getBelongsTo();
        $meta['objetoPadre'] = array(
            'title' => $objetoPadre->getMetatagTitle(),
            'description' => $objetoPadre->getMetatagDescription(),
            'keyWords' => $objetoPadre->getMetatagKeywords(),
            'titleSimple' => $objetoPadre->getMetatagTitleSimple()->getIDTipo(),
            'titlePosition' => $objetoPadre->getMetatagTitlePosition()->getIDTipo(),
            'revisitAfter' => $objetoPadre->getRevisitAfter(),         
        );

        unset($objetoActual);
        unset($objetoPadre);
        
        foreach ($meta['pro'] as $key => $value) {
            if (trim($meta['objetoActual'][$key]) != '') {
                $metaInformacion[$key] = $meta['objetoActual'][$key];
            } elseif (trim($meta['objetoPadre'][$key]) != '') {
                $metaInformacion[$key] = $meta['objetoPadre'][$key];
            } else {
                $metaInformacion[$key] = $value;
            }
        }

        return $metaInformacion;
    }
    
    /**
     * Devuelve un array con la traducción de los textos de la etiquetas
     * de la web en el idioma $lang.
     * 
     * Si el idioma solicitado no estuviese disponible (no contratado, no traducido),
     * se muestra el español.
     * 
     * Asigna a la variable de session $_SESSION['LANGUAGE'] el lenguaje
     * 
     * @param string $lang El idioma a cargar.
     * @return array Array con la traducción
     */
    protected function getEtiquetasIdioma($lang) {

        $array = array();

        $file = "lang/{$lang}.yml";
        if (file_exists($file)) {
            $etiquetas = sfYaml::load($file);
            $array = $etiquetas['lang'];
        }

        return $array;
    }

    /**
     * Devuelve un array con la traducción de los párrafos
     * del controller en curso en el idioma $lang.
     * 
     * Si el idioma solicitado no estuviese disponible (no contratado, no traducido),
     * se muestra el español.
     * 
     * @param string $lang El idioma a cargar.
     * @return array Array con la traducción
     */
    protected function getTextosIdioma($lang) {

        $array = array();

        $file = "modules/{$this->entity}/lang.yml";
        if (file_exists($file)) {
            $textos = sfYaml::load($file);
            $array = isset($textos[$lang]) ? $textos[$lang] : $textos['es'];
        }

        return $array;
    }

    /**
     * Devuelve el idioma a utilizar
     * 
     * Será el indicado en $_SESSION['LANGUAGE'] o en su defecto el
     * de la cabecera del request (el del visitante).
     * 
     * En cualquier caso, si en la carpeta 'lang' no existiese el archivo yml correspondiente al mismo
     * o no estuviese contratado, se devolverá el español
     * 
     * @return string EL idioma
     */
    protected function getIdioma() {

        $idioma = ($_SESSION['LANGUAGE'] == '') ?
                substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) :
                $_SESSION['LANGUAGE'];

        if (!(file_exists("lang/{$idioma}.yml")) or !(in_array($idioma, $this->getIdiomasPermitidos())))
            $idioma = 'es';

        return $idioma;
    }

    /**
     * Devuelve un array con los idiomas permitidos para la web
     * que están definidos en $this->varWeb['Pro']['globales']['lang']
     * 
     * Si no hubiera ninguno, se pone el español (es)
     * 
     * @return array Idiomas permitidos
     */
    protected function getIdiomasPermitidos() {

        $aux = trim($this->varWeb['Pro']['globales']['lang']);
        if ($aux == '')
            $aux = 'es';

        return explode(",", $aux);
    }

    /**
     * 
     * METODOS PARA LA TIENDA ONLINE
     * 
     */

    /**
     * Devuelve un array de objetos artículos que
     * pertenecen a la zona $zona y al controlador $controller
     * 
     * Si no se indica controlador, se toma el que está en curso
     * Si no se indica zona, se devuelven todos los artículos agrupados por zonas
     * 
     * El array tiene tantos elementos como zonas de articulos
     * y a su vez cada zona tiene tantos elementos con artículos haya en dicha zona
     * 
     * @param string $controller El nombre del controlador. Opcional, por defecto el que está en curso
     * @param string $zona El codigo de la zona. Opcional, por defecto todas.
     * @return array Array de objetos artículos
     */
    protected function getArticulosZona($controller = '', $zona = '') {

        $array = array();

        if ($controller == '')
            $controller = $this->entity;

        $controller = ucwords($controller);

        $filtroZona = ($zona == '') ? "1" : "Zona='{$zona}'";

        $itemsPagina = 0;

        $zonas = new CpanEsqueletoWeb();
        $reglas = $zonas->cargaCondicion("Id,Zona,NItems,ItemsPagina", "Controller='{$controller}' AND {$filtroZona}", "SortOrder ASC");
        unset($zonas);

        $ordenArticulos = new ErpOrdenesArticulos();
        foreach ($reglas as $regla) {
            
            if ($regla['ItemsPagina'] > $itemsPagina)
                $itemsPagina = $regla['ItemsPagina'];
            
            $articulos = $ordenArticulos->getArticulos($regla['Id'], $regla['NItems']);
            
            foreach ($articulos as $articulo)
                $array[$regla['Zona']][$articulo->getId()] = $articulo;
        }
        unset($ordenArticulos);

        return $array;
    }

    /**
     * Devuelve el objeto articúlo cuyo id es $idArticulo o un
     * array con las columnas del artículo indicadas en $arrayColumnas
     * 
     * @param integer $idArticulo El id del artículo
     * @param array $arrayColumnas Columnas a devolver
     * @return array
     */
    protected function getArticulo($idArticulo, $arrayColumnas = '') {
        
        $array = array();
        
        $articulo = $this->getObjeto('ErpArticulos', $idArticulo, $arrayColumnas);
        
        return $array;
        
    }
}

?>
