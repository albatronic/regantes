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
        $this->values['contenido'] = $this->getContenido($this->request['IdEntity']);
        
        /* GALERIA DE IMÁGENES */
        $this->values['galeriaFotos'] = $this->getAlbumExterno($this->request['IdEntity'],8);
        
        /* ENLACES RELACIONADOS */        
        $this->values['enlacesRelacionados'] = $this->getEnlacesRelacionados($this->request['IdEntity']);

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
