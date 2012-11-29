<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @version 1.0 26-nov-2012
 */
class ContenidosController extends ControllerProject {

    protected $entity = "Contenidos";

    public function IndexAction() {

        /* CONTENIDO */
        $this->values['contenidoDesarrollado'][] = array(
            'fecha' => '29 Octubre 2012',
            'titulo' => 'Donec sodales molestie urna vitae accumsan',
            'subtitulo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mi quam, luctus a fermentum vitae, auctor vel sem',
            'intro' => 'Mauris rhoncus, lectus nec blandit malesuada, sem sem tristique est, sit amet egestas sem tellus sed est. Aenean posuere porta lectus, a pellentesque velit malesuada ut.',
            'parrafo' => 'Lorem ipsum <img src="" /> dolor sit amet, duis a vulputate pellentesque elit, justo ultricies, class duis diam ultricies, ultrices ac nascetur iaculis praesent eu mollis. Interdum vitae leo est felis, dolor a integer sed at lobortis pellentesque. Ligula libero aenean eu magna faucibus ante, ut aptent dolor exercitationem, ante lacinia, est ut in mauris et. Mauris lorem, eleifend nunc et malesuada eget nonummy duis, libero ac ultricies cras. Ipsum dictum dolore nulla mollis in sed, sed in, quisque vitae in arcu porttitor elit sed, ipsum at et curabitur dolor, augue in mollis pede. Magna eget at augue, a mollis semper wisi fringilla pellentesque nunc. Posuere justo, dui duis, ultrices tellus erat odio ac, ipsum faucibus nibh in quam nunc. Sollicitudin purus ultrices, sed ligula potenti pede eleifend. In pretium vel, nibh aliquet luctus ut et, donec vestibulum eu.',
            'imagen' => array(
                'nombreImagen' => 'Este es el nombre de la imagen',
                'urlImagen' => 'xxx-imagen-contenido1.jpg'
            ),
            'videoYoutube' => array(// Puede haber N
                'video' => 'u4Qjff2BMsk',
                'ancho' => '604',
                'alto' => '330',
                'anchoBorde' => '0'
            ),
        );


        /* ARCHIVOS ADJUNTOS */
        $this->values['archivosAdjuntos'][left][] = array(
            'nombre' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mi quam, luctus a fermentum vitae, auctor vel sem.',
            'enlace' => 'adfad'
        );

        $this->values['archivosAdjuntos'][left][] = array(
            'nombre' => 'Curabitur non ipsum nunc.',
            'enlace' => 'adfad'
        );

        $this->values['archivosAdjuntos'][right][] = array(
            'nombre' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'enlace' => 'adfad'
        );

        $this->values['archivosAdjuntos'][right][] = array(
            'nombre' => 'Donec sodales molestie urna vitae accumsan.',
            'enlace' => 'adfad'
        );


        /* ENLACES RELACIONADOS */
        $this->values['enlacesRelacionados'][left][] = array(
            'nombre' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mi quam, luctus a fermentum vitae, auctor vel sem.',
            'enlace' => 'www.elpais.com',
            'url' => 'http://sfgsfg'
        );

        $this->values['enlacesRelacionados'][left][] = array(
            'nombre' => 'Curabitur non ipsum nunc.',
            'enlace' => 'www.articoestudio.com',
            'url' => 'http://lkjasd'
        );

        $this->values['enlacesRelacionados'][right][] = array(
            'nombre' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'enlace' => 'www.pensandoenweb.es',
            'url' => 'http://wecksdi'
        );

        $this->values['enlacesRelacionados'][right][] = array(
            'nombre' => 'Donec sodales molestie urna vitae accumsan.',
            'enlace' => 'otro enlace',
            'url' => 'http://qwsdflklj'
        );


        /* GALERIA FOTOS */
        $this->values['galeriaFotos']['nThumbnail'] = 7;


        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria1.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria2.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria3.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria4.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria5.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria5.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria5.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaFotos']['thumbnail'][] = array(
            'tituloGaleria' => 'Título de la Galería de Fotos',
            'nombre' => 'sd',
            'imagen' => 'images/xxx-imagen-galeria5.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );


        return parent::IndexAction();
    }

    public function ListadoContenidosAction() {

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



        /* LISTADO DE CONTENIDOS */
        $this->values['listadoContenidos'] = array(
            'tituloListado' => 'class duis diam ultricies',
        );

// HAY PAGINACION: ANTERIOR Y SIGUIENTE

        $this->values['listadoContenidosDesarrollo'][] = array(
            'fecha' => '01/10/2012',
            'titulo' => 'Maecenas fringilla lobortis neque sit amet tincidunt',
            'enlace' => 'contenidos',
            'subtitulo' => '',
            'intro' => 'In porttitor mollis lobortis. Integer tempor malesuada nisl, vitae ultricies tellus sollicitudin hendrerit. Fusce tempor tellus sit amet odio scelerisque ut rutrum lectus hendrerit. Vestibulum semper commodo sagittis.',
        );

        $this->values['listadoContenidosDesarrollo'][] = array(
            'fecha' => '01/10/2012',
            'titulo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mi quam, luctus a fermentum vitae, auctor vel sem.',
            'enlace' => '',
            'subtitulo' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'intro' => '',
        );

        $this->values['listadoContenidosDesarrollo'][] = array(
            'fecha' => '',
            'titulo' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'enlace' => 'contenidos',
            'subtitulo' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'intro' => 'Donec neque nisi, porta eget gravida vel, vehicula id tortor. Nunc viverra laoreet euismod. Aliquam est velit, laoreet sed accumsan at, blandit nec risus. Duis hendrerit enim eu ipsum dignissim varius. Sed ut lacinia libero. Cras turpis justo, placerat pulvinar convallis nec, elementum condimentum nunc. Praesent sapien lacus, malesuada ac semper at, ultrices vitae eros. Vestibulum et arcu justo, fermentum laoreet mauris. Aenean ut leo tortor.',
        );



        return array(
            'template' => $this->entity . '/listadoContenidos.html.twig',
            'values' => $this->values
        );
    }

    public function ListadoSubseccionesAction() {

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

// NO HAY PAGINACION

        /* LISTADO DE SUBSECCIONES */
        $this->values['listadoSubsecciones'] = array(
            'tituloListado' => 'class duis diam ultricies',
        );


        $this->values['subseccion'][] = array(
            'fecha' => '01/10/2012',
            'titulo' => 'Maecenas fringilla lobortis neque sit amet tincidunt',
            'enlace' => 'contenidos',
        );

        $this->values['subseccion'][] = array(
            'fecha' => '01/10/2012',
            'titulo' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin mi quam, luctus a fermentum vitae, auctor vel sem.',
            'enlace' => '',
        );

        $this->values['subseccion'][] = array(
            'fecha' => '',
            'titulo' => 'Ut scelerisque nibh ac leo cursus iaculis. Curabitur non ipsum nunc.',
            'enlace' => 'contenidos',
        );



        return array(
            'template' => $this->entity . '/listadoSubsecciones.html.twig',
            'values' => $this->values
        );
    }

}

?>
