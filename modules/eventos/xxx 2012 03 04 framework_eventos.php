<?php


include ('dmntr/funciones/decode_gestorcontenidos_acentos_v2.php');


$year_evento_problema=substr($fecha_evento,0,4); 
$mes_evento_problema=substr($fecha_evento,5,2); 
$dia_evento_problema=substr($fecha_evento,8,2);

$mes_evento_problema_texto=veo_nombremes($mes_evento_problema);



echo '<div id="contenedor_global"> <!-- INICIO: <div id="contenedor_global">  -->';

include('estructura/pestania_logueado.php');

include('estructura/cabecera_menu.php');


echo '<div id="banda_azul_cabecera">Agenda</div>';


echo '<div id="zona_contenidos"> <!-- INICIO: <div id="zona_contenidos">  -->';

//echo '<h1>Agenda</h1>';

echo '<div id="fechaagenda">'; 
		echo $dia_evento_problema," de ",$mes_evento_problema_texto," de ",$year_evento_problema;
echo '</div>';



$sqleventos="select num_contenido_md5 from eventos where fechaevento='$fecha_evento' order by horaevento asc";
$reseventos=mysql_query($sqleventos,$db);
while ($regeventos=mysql_fetch_array($reseventos))
{ 
$num_contenido_md5_evento=$regeventos['num_contenido_md5'];

	include('eventos/contenidos_evento.php'); 
}


		echo '<div id="piepagina_contenidos">';
			echo '<a href="javascript:history.back()">';
			echo "<img src='imagenes/b_volver.png' alt='Volver' />";
			echo "</a>";
		echo '</div>';



echo '</div> <!-- FIN: <div id="zona_contenidos">  -->';


echo '</div> <!-- FIN: <div id="contenedor_global">  -->';


include('menus/pie_pagina.php');

?>