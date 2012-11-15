<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class AccesoController extends ControllerWeb {

    protected $entity = "Acceso";

    public function IndexAction() {

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

        /* MENSAJE */
        $this->values['mensaje'] = array(
            'acceso' => 'Nullam iaculis tortor id diam iaculis convallis. In porttitor mollis lobortis. Integer tempor malesuada nisl, vitae ultricies tellus sollicitudin hendrerit. Fusce tempor tellus sit amet odio scelerisque ut rutrum lectus hendrerit. Vestibulum semper commodo sagittis.',
        );
                
        
        return array(
            'template' => $this->entity . '/Index.html.twig',
            'values' => $this->values
        );
    }

}

?>