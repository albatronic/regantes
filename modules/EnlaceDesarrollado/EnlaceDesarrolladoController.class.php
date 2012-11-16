<?php

/**
 * Description of IndexController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 06-nov-2012
 *
 */
class EnlaceDesarrolladoController extends ControllerWeb {

    protected $entity = "EnlaceDesarrollado";

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

        /* ENLACES DE INTERES */
        $this->values['enlacesInteres'] = array(
            'tituloSeccion' => 'Fusce tempor tellus sit amet odio scelerisque ut rutrum lectus hendrerit.',
        );
        
        $this->values['enlaceIndividual'][] = array(
            'titulo' => 'Integer tempor malesuada nisl, vitae ultricies tellus sollicitudin hendrerit. Fusce tempor tellus sit amet odio scelerisque ut rutrum lectus hendrerit. Vestibulum semper commodo sagittis.',
            'seccion' => '',
            'nombre' => 'www.ideal.es',
            'url' => 'http://www.ideal.es',
        );

        $this->values['enlaceIndividual'][] = array(
            'titulo' => 'Fusce tempor tellus sit amet odio scelerisque ut rutrum lectus hendrerit. Vestibulum semper commodo sagittis.',
            'seccion' => '',
            'nombre' => 'www.ideal.es',
            'url' => 'http://www.ideal.es',
        );        
            
        
   
                
        
        return array(
            'template' => $this->entity . '/Index.html.twig',
            'values' => $this->values
        );
    }

}

?>
