<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class IndexController extends ControllerProject {

    protected $entity = "Index";
    protected $nivel = "";
    
    public function pintaArbol($arbol) {
        echo "<ul style='margin-left: 40px;'>";
        foreach ($arbol as $hijo => $familia) {
            echo "<li>{$hijo}";
            echo $this->pintaArbol($familia);
            echo "</li>";
        }
        echo "</ul>";
    }
    
    public function IndexAction() {

        $seccion = new GconSecciones(1);
        $arbol = $seccion->getHijos();
        //$this->pintaArbol($arbol);
        //echo "<pre>";print_r($arbol);echo "</pre>";
        
        /* SLIDER DE IMAGENES */
        $this->values['sliderImagenes'][0] = array(
            'imagen' => 'images/xxxslider3.jpg',
            'url' => 'sfgsfgf',
            'texto' => array(
                'titulo' => 'kajfalf adlfkajdf asiasdf',
                'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus. Integer dapibus faucibus ante id rutrum.',
            ),
        );

        $this->values['sliderImagenes'][1] = array(
            'imagen' => 'images/xxxslider1.jpg',
            'url' => '',
            'texto' => array(
                'titulo' => 'segundo titulo',
                'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus. Integer dapibus faucibus ante id rutrum.',
            ),
        );

        $this->values['sliderImagenes'][2] = array(
            'imagen' => 'images/xxxslider1.jpg',
            'url' => '',
            'texto' => array(
                'titulo' => '',
                'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus. Integer dapibus faucibus ante id rutrum.',
            ),
        );

        /* SLIDER NOTICIAS */
        $this->values['sliderNoticias'] = $this->getNoticias();

        /* EVENTOS */
        $this->values['eventos'] = $this->getEventos(2);

        /* NOTICIAS MAS LEIDAS */
        $this->values['noticias'] = $this->getNoticiasMasLeidas(3);

        /* CONTENIDOS */
        $this->values['contenidosVisitados']['left'][] = array(
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
        );

        $this->values['contenidosVisitados']['left'][] = array(
            'titulo' => 'Maecenas dapibus rutrum rhoncus.',
            'url' => 'hhtp://www.google.es',
        );

        $this->values['contenidosVisitados']['left'][] = array(
            'titulo' => 'Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
        );

        $this->values['contenidosVisitados']['right'][] = array(
            'titulo' => 'Bla bla bla rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
        );

        $this->values['contenidosVisitados']['right'][] = array(
            'titulo' => 'Otro titulo',
            'url' => 'hhtp://www.google.es',
        );


        /* PRESIDENTE */
        $this->values['presidente'] = array(
            'imagen' => 'images/xxximagen-presidente.jpg',
            'parrafo' => 'Mauris luctus massa at mi placerat faucibus. Suspendisse ligula quam, faucibus ut luctus dapibus, placerat in eros. Quisque in metus nisl, ut porttitor dolor. Nam vestibulum vestibulum congue.',
        );

        /* GALERIA FOTOS */
        $this->values['galeriaFotos']['nThumbnail'] = 4;


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


        /* VIDEO YOUTUBE */
        $this->values['videoYoutube'] = array(
            'titulo' => 'Título del vídeo tararí que te vi',
            'embed' => 'u4Qjff2BMsk',
        );


        return parent::IndexAction();
    }

}

?>
