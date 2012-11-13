<?php
include ('dmntr/funciones/decode_gestorcontenidos_acentos_v2.php');


$year_evento_problema=substr($fecha_evento,0,4); 
$mes_evento_problema=substr($fecha_evento,5,2); 
$dia_evento_problema=substr($fecha_evento,8,2);

$mes_evento_problema_texto=veo_nombremes($mes_evento_problema);

echo '<div id="contenedorGeneral">';

	include ("layout/menu-cabecera.php"); // MENÚ CABECERA
	include ("layout/menu-izquierda.php"); // MENÚ IZQUIERDA
	include ("layout/foto-cabecera.php"); // FOTOGRAFÍA CABECERA
	
	echo '<div id="contenedorCentral">'; // INICIO: <div id="contenedorCentral">


		echo '<div class="cabecera">';
			echo '<h1>Agenda de Eventos</h1>';
			echo '<div class="fecha">'.$dia_evento_problema," de ",$mes_evento_problema_texto," de ",$year_evento_problema.'</div>';
		echo '</div>';

$sqleventos="select num_contenido_md5 from eventos where fechaevento='$fecha_evento' order by horaevento asc";
$reseventos=mysql_query($sqleventos,$db);
while ($regeventos=mysql_fetch_array($reseventos))
{ 
$num_contenido_md5_evento=$regeventos['num_contenido_md5'];

	include('eventos/contenidos_evento.php'); 
}

		
		echo '<div id="masNoticias">';
			//echo '<a href="noticias.php" title="M&aacute;s Noticias"> <img src="imagenes/mas-noticias.png" title="M&aacute;s Noticias" alt="M&aacute;s Noticias" /> </a>';
			echo '<a href="javascript:history.back()" title="Volver">';
			echo "<img src='imagenes/b_volver.png' alt='Volver' title='Volver' />";
			echo "</a>";

		echo '</div>';


	
	echo '</div>'; // FIN: <div id="contenedorCentral">
	
	include ("layout/pie.php"); // PIE DE PÁGINA
	
echo '</div>';


?>