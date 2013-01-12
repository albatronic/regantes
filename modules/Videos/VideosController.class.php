<?php

/**
 * Description of VideosController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 26-nov-2012
 */
class VideosController extends ControllerProject {

    var $entity = "Videos";

    public function IndexAction() {


        /* GALERIA VIDEO */
        $this->values['galeriaVideos'] = $this->getVideos(0,-1);
        /**
        $this->values['galeriaVideos']['thumbnail'][1] = array(
            'titulo' => 'Lorem ipsum dolor sit amet',
            'imagen' => 'images/xxx-video.jpg',
            'enlaceVideo' => 'video',
        );

        $this->values['galeriaVideos']['thumbnail'][2] = array(
            'titulo' => 'Vestibulum porttitor justo vel lorem varius eu pretium magna blandit.',
            'imagen' => 'images/xxx-imagen-contenido1.jpg',
            'enlaceVideo' => 'video',
        );

        $this->values['galeriaVideos']['thumbnail'][3] = array(
            'titulo' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'imagen' => 'images/xxximagen-eventos2.jpg',
            'enlaceVideo' => 'video',
        );


        $this->values['galeriaVideos']['thumbnail'][4] = array(
            'titulo' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'imagen' => 'images/xxximagen-eventos2.jpg',
            'enlaceVideo' => 'video',
        );

        $this->values['galeriaVideos']['thumbnail'][5] = array(
            'titulo' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'imagen' => 'images/xxximagen-eventos2.jpg',
            'enlaceVideo' => 'video',
        );
*/
        return parent::IndexAction();
    }

    public function ShowItemAction() {

        /* VIDEO YOUTUBE */
        $this->values['video'] = array(
            'titulo' => 'Título del vídeo tararí que te vi',
            'embed' => 'u4Qjff2BMsk',
            'autor' => 'Praesent at felis sem.',
            'descripcion' => 'Duis eget vestibulum nunc. Etiam eros mi, dignissim eget auctor ultricies, vehicula vitae mauris. Proin sit amet massa mi, eu sodales tellus. Pellentesque eu lectus in enim eleifend aliquet. Proin iaculis egestas est et placerat. Pellentesque id justo purus. Nulla facilisi. Integer leo quam, sollicitudin at blandit in, rhoncus sit amet ante. Proin bibendum, eros at tincidunt feugiat, eros justo dictum libero, eu congue magna neque non quam.',
        );


        return array(
            "template" => $this->entity . "/videoIndividual.html.twig",
            "values" => $this->values,
        );
    }

}

?>
