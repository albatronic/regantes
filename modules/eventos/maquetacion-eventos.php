<?php

echo '<div id="contenedorGeneral">';

	include ("layout/menu-cabecera.php"); // MEN� CABECERA
	include ("layout/menu-izquierda.php"); // MEN� IZQUIERDA
	include ("layout/foto-cabecera.php"); // FOTOGRAF�A CABECERA
	
	echo '<div id="contenedorCentral">'; // INICIO: <div id="contenedorCentral">
		include("eventos/listado-eventos.php"); // EVENTOS
		include ("layout/pie.php"); // PIE DE P�GINA
	echo '</div>'; // FIN: <div id="contenedorCentral">
	
echo '</div>';


?>