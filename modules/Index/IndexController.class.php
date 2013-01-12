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
    protected $nivel = "";
    
    public function IndexAction() {
        
        /* SLIDER DE IMAGENES */
        $this->values['sliderImagenes'] = $this->getSliders();

        /* SLIDER NOTICIAS */
        $this->values['carruselNoticias'] = $this->getNoticias(true,2,1);

        /* EVENTOS */
        $this->values['eventos'] = $this->getEventos('',2);

        /* LAS NOTICIAS MÁS LEIDAS */
        $this->values['noticias'] = $this->getNoticiasMasLeidas(0,2);

        /* LOS CONTENIDOS MAS VISITADOS */
        $this->values['contenidosVisitados'] = $this->getContenidosMasVisitados(6);

        /* PRESIDENTE */
        $this->values['presidente'] = $this->getContenido($this->varWeb['Pro']['staticContents'][0], array('Resumen'));

        /* GALERIA FOTOS */
        $this->values['galeriaFotos'] = $this->getAlbumes(1,"",1,5);      

        /* VIDEO YOUTUBE */
        $this->values['videoYoutube'] = array(
            'titulo' => 'Título del vídeo tararí que te vi',
            'embed' => 'u4Qjff2BMsk',
        );

        return parent::IndexAction();
    }

}

?>
