<?php
//echo '<div class="contenedor_cadanoticia">'; // INICIO: __________________ <div id="contenedor_cadanoticia">




echo '<div class="contenedor_solo_texto_noticias_ancho">'; //INICIO: CONTENEDOR TEXTO

echo '<h2>';
echo '<a href="index.php?g=1&amp;c='.$c.'&amp;c2='.$c2.'&amp;f1=contenidos&amp;s1=see_contenido_seleccionado&amp;f2='.$f2.'&amp;s2='.$s2.'&amp;pag='.$pag.'&amp;orden='.$orden.'&amp;criterio='.$criterio.'&amp;ob='.$ob.'&amp;spp='.$spp.'&amp;sp='.$sp.'&amp;cp='.$num_contenido_md5.'&amp;source=agenda&amp;fecha_evento='.$fecha_evento.'&amp;mes_almanaque='.$mes_almanaque.'&amp;year_almanaque='.$year_almanaque.'">';
echo $titulo;
echo '</a>';
echo '</h2>';

echo '<h3>';
echo $subtitulo;
echo '</h3>';


echo '<div class="resumenportada">';
echo $resumen;
echo '&nbsp;<a href="index.php?g=1&amp;c='.$c.'&amp;c2='.$c2.'&amp;f1=contenidos&amp;s1=see_contenido_seleccionado&amp;f2='.$f2.'&amp;s2='.$s2.'&amp;pag='.$pag.'&amp;orden='.$orden.'&amp;criterio='.$criterio.'&amp;ob='.$ob.'&amp;spp='.$spp.'&amp;sp='.$sp.'&amp;cp='.$num_contenido_md5.'&amp;source=agenda&amp;fecha_evento='.$fecha_evento.'&amp;mes_almanaque='.$mes_almanaque.'&amp;year_almanaque='.$year_almanaque.'">';
echo '[+]';
echo '</a>';
echo '</div>';


echo '</div>'; //FIN: CONTENEDOR TEXTO


//echo '</div>'; // FIN: __________________ <div id="contenedor_cadanoticia">

echo '<div class="separacion_eventosfecha">&nbsp;</div>'; //FIN: <div class="separacion_noticiasportada">

?>