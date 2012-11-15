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
class NoticiasController extends ControllerWeb {

    var $entity = "Noticias";

    public function IndexAction() {

        /* USTED ESTA EN */
        $this->values['ustedEstaEn'] = array(
            'titulo' => 'Noticias',
            'subsecciones' => array(
                'Sub pepito' => 'http://asdfasdf',
                'Sub manolito' => 'http://asdfasdfasdfasdf',
                'Sub sdfg' => 'http://asdfasdfasdfasdf',
                'Aenean consequat iaculis arcu sit amet faucibus. Fusce posuere posuere scelerisque.' => 'http://asdfasdfasdfasdf',
            ),

        );
        
                
        /* NOTICIAS */
        $this->values['eventos'][left][] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => 'images/xxximagen-eventos1.jpg',

        ); 
        
        $this->values['eventos'][left][] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => '',

        ); 
        
        $this->values['eventos'][right][] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Ut ac libero sed ipsum ornare scelerisque at eget nisl. Curabitur elementum eleifend nulla, id sodales elit porttitor in.',
            'imagen' => '',

        ); 
        
        $this->values['eventos'][right][] = array(
            'fecha' => '29/10/2012',
            'titulo' => 'Primer título de la notica. Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'subtitulo' => 'Maecenas dapibus rutrum rhoncus. Integer ut dui ligula',
            'url' => 'hhtp://www.google.es',
            'descripcion' => 'Suspendisse aliquam, quam nec interdum auctor, felis enim faucibus ligula, in pellentesque libero tortor lectus. Quisque ornare suscipit rhoncus.',
            'imagen' => 'images/xxximagen-eventos2.jpg',

        );         
        
        
        
        
        /*print_r($this->values['ustedEstaEn']);*/

        return array(
            "template" => $this->entity . "/Index.html.twig",
            "values" => $this->values,
        );
    }

}

?>
