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

        /* GALERIA IMAGENES */
        $this->values['galeriaImagenes'] = $this->getAlbumes(-1,0,999,999);
/**
        $this->values['galeriaImagenes'][3] = array(
            'tituloGaleria' => 'Quisque tincidunt augue at velit mattis commodo quis vitae urna.',
            'nombre' => 'Lorem ipsum dolor sit amet',
            'imagen' => 'images/xxx-imagen-galeria1.jpg',
            'enlaceImagen' => 'http://lorempixel.com/500/300/nature',
        );
*/

        return parent::IndexAction();
    }

}

?>
