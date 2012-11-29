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

    public function IndexAction() {

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
        $this->values['sliderNoticias'][0] = array(
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => '',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => 'images/xxximagen-noticia.jpg',
        );

        $this->values['sliderNoticias'][1] = array(
            'titulo' => 'Segundo título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => '',
        );

        $this->values['sliderNoticias'][2] = array(
            'titulo' => 'Tercer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => '',
            'imagen' => '',
        );



        /* EVENTOS */
        $this->values['eventos'][0] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => 'images/xxximagen-eventos1.jpg',
        );

        $this->values['eventos'][1] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => '',
        );


        /* NOTICIAS MAS LEIDAS */
        $this->values['noticias'][0] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => 'images/xxximagen-eventos1.jpg',
        );

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
