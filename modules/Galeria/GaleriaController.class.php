<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author Administrador
 */
class GaleriaController extends ControllerProject {

    var $entity = "Galeria";

    public function IndexAction() {

        /* GALERIA VIDEO */
        /* $this->values['galeriaVideos'][1] = array(
          'titulo' => 'Lorem ipsum dolor sit amet',
          'imagen' => 'images/xxx-video.jpg',
          'enlaceVideo' => 'http://lorempixel.com/500/300/nature',
          );

          $this->values['galeriaVideos'][2] = array(
          'titulo' => 'Vestibulum porttitor justo vel lorem varius eu pretium magna blandit.',
          'imagen' => 'images/xxx-imagen-contenido1.jpg',
          'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
          );

          $this->values['galeriaVideos'][3] = array(
          'titulo' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
          'imagen' => 'images/xxximagen-eventos2.jpg',
          'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
          ); */



        /* GALERIA IMAGENES */
        $this->values['galeriaImagenes'][1] = array(
            'tituloGaleria' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'nombre' => 'Lorem ipsum dolor sit amet',
            'imagen' => 'images/xxx-imagen-galeria1.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaImagenes'][2] = array(
            'tituloGaleria' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'nombre' => 'Lorem ipsum dolor sit amet',
            'imagen' => 'images/xxx-imagen-galeria1.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );

        $this->values['galeriaImagenes'][3] = array(
            'tituloGaleria' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'nombre' => 'Lorem ipsum dolor sit amet',
            'imagen' => 'images/xxx-imagen-galeria1.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );


        return parent::IndexAction();
    }

}

?>
