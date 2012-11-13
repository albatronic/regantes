<?php

echo '<div id="contenedorGeneral">';

	include ("layout/menu-cabecera.php"); // MENÚ CABECERA
	include ("layout/menu-izquierda.php"); // MENÚ IZQUIERDA
	include ("layout/foto-cabecera.php"); // FOTOGRAFÍA CABECERA
	
	echo '<div id="contenedorCentral">'; // INICIO: <div id="contenedorCentral">
		include("eventos/listado-eventos.php"); // EVENTOS
		include ("layout/pie.php"); // PIE DE PÁGINA
	echo '</div>'; // FIN: <div id="contenedorCentral">
	
echo '</div>';


?>