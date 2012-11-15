<?php

include ('dmntr/funciones/decode_gestorcontenidos_acentos_v2.php');

/*
$g=$_GET['g'];

		if (isset($g)) { 
				$fecha_evento=$_GET['fecha_evento']; // Nmero de Contenidos que tiene esa Seccin
		}else{
				$fecha_evento=$_POST['fecha_evento'];
		}
*/
				$fecha_evento=$_GET['fecha_evento']; 


$year_evento_problema=substr($fecha_evento,0,4); 
$mes_evento_problema=substr($fecha_evento,5,2); 
$dia_evento_problema=substr($fecha_evento,8,2);

$mes_evento_problema_texto=veo_nombremes($mes_evento_problema);


echo '<div id="contenedor_listadoeventosagenda">'; // INICIO: __________________ <div id="contenedor_listadoeventosagenda">


echo '<h1>Agenda</h1>';


echo '<div id="fecha_eventoagenda">'; 
		echo $dia_evento_problema," de ",$mes_evento_problema_texto," de ",$year_evento_problema;
echo '</div>';



$query="lock tables eventos read, contenidos_v2 read"; $result=mysql_query($query,$db); 


$sqleventos="select num_contenido_md5 from eventos where fechaevento='$fecha_evento' order by horaevento asc";
$reseventos=mysql_query($sqleventos,$db);
while ($regeventos=mysql_fetch_array($reseventos))
{ 
$num_contenido_md5_evento=$regeventos['num_contenido_md5'];

	include('eventos/contenidos_evento.php'); 
}
		

$query="unlock tables"; $result=mysql_query($query,$db); 

echo '</div>'; // FIN: __________________ <div id="contenedor_listadoeventosagenda">

?>