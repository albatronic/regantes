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
class Error404Controller extends ControllerWeb {

    var $entity = "Error404";

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
        
        /*print_r($this->values['ustedEstaEn']);*/

        return array(
            "template" => $this->entity . "/Index.html.twig",
            "values" => $this->values,
        );
    }

}

?>
