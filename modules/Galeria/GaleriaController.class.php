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
class GaleriaController extends ControllerWeb {

    var $entity = "Galeria";

    public function IndexAction() {

        /* USTED ESTA EN */
        $this->values['ustedEstaEn'] = array(
            'titulo' => 'Error 404',
            'subsecciones' => array(
                'Sub pepito' => 'http://asdfasdf',
                'Sub manolito' => 'http://asdfasdfasdfasdf',
                'Sub sdfg' => 'http://asdfasdfasdfasdf',
                'Aenean consequat iaculis arcu sit amet faucibus. Fusce posuere posuere scelerisque.' => 'http://asdfasdfasdfasdf',
            ),

        );
        
        /* GALERIA VIDEO */
        $this->values['galeriaVideos'][1] = array(
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
        );            
        
        /*print_r($this->values['ustedEstaEn']);*/

        return array(
            "template" => $this->entity . "/Index.html.twig",
            "values" => $this->values,
        );
    }

}

?>
