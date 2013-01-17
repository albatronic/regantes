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
        $slider = new SldSliders();
        $rows = $slider->cargaCondicion("Id", "IdTipo='2'");
        $tipo = (count($rows)) ? 2: 0;
        unset($slider);     
        $this->values['sliderImagenes'] = $this->getSliders(1, $tipo);

        /* SLIDER NOTICIAS */
        $this->values['carruselNoticias'] = $this->getNoticias(true, 2, 1);

        /* EVENTOS ÚNICOS. */
        $this->values['eventos'] = $this->getEventos('','', 3,2,true);

        /* LAS NOTICIAS MÁS LEIDAS */
        $this->values['noticias'] = $this->getNoticiasMasLeidas(0, 2);

        /* LOS CONTENIDOS MAS VISITADOS */
        $this->values['contenidosVisitados'] = $this->getContenidosMasVisitados(6);

        /* PRESIDENTE */
        $this->values['presidente'] = $this->getContenido($this->varWeb['Pro']['staticContents'][0], array('Resumen'));

        /* GALERIA FOTOS */
        $this->values['galeriaFotos'] = $this->getAlbumes(1, "", 1, 5);

        /* VIDEO YOUTUBE */
        $this->values['videoYoutube'] = $this->getVideos(0,1,1);

        return parent::IndexAction();
    }

}

?>
