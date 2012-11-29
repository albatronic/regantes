<?php


/**
 * Description of NoticiasController
 *
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright ÁRTICO ESTUDIO
 * @date 26-nov-2012
 */
class NoticiasController extends ControllerProject {

    var $entity = "Noticias";

    public function IndexAction() {


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


        return parent::IndexAction();
    }

}

?>
