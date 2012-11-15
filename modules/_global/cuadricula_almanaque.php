<?php
$etq_dialunes="LUN";
$etq_diamartes="MAR";
$etq_diamiercoles="MIE";
$etq_diajueves="JUE";
$etq_diaviernes="VIE";
$etq_diasabado="SAB";
$etq_diadomingo="DOM";

if($mesactual_texto=="Enero"){$mesactual_texto="Enero";}
if($mesactual_texto=="Febrero"){$mesactual_texto="Febrero";}
if($mesactual_texto=="Marzo"){$mesactual_texto="Marzo";}
if($mesactual_texto=="Abril"){$mesactual_texto="Abril";}
if($mesactual_texto=="Mayo"){$mesactual_texto="Mayo";}
if($mesactual_texto=="Junio"){$mesactual_texto="Junio";}
if($mesactual_texto=="Julio"){$mesactual_texto="Julio";}
if($mesactual_texto=="Agosto"){$mesactual_texto="Agosto";}
if($mesactual_texto=="Septiembre"){$mesactual_texto="Septiembre";}
if($mesactual_texto=="Octubre"){$mesactual_texto="Octubre";}
if($mesactual_texto=="Noviembre"){$mesactual_texto="Noviembre";}
if($mesactual_texto=="Diciembre"){$mesactual_texto="Diciembre";}



$mesactual=$_GET['mes_almanaque'];
$yearactual=$_GET['year_almanaque'];


if(strlen($mesactual)<1){
	if(strlen($mesactual_evento)>0){$mesactual=$mesactual_evento;}
	if(strlen($yearactual_evento)>0){$yearactual=$yearactual_evento;}
}



// La primera vez que se carga la pgina, se muestra el Mes y el Ao Actual
if (!isset($mesactual)) { 
$fecha=date(dmY); 
$diaactual=substr($fecha,0,2); 
$mesactual=substr($fecha,2,2); 
$yearactual=substr($fecha,4,4);
}

if(strlen($mesactual)<2){$texto_mesactual="0".$mesactual;}else{$texto_mesactual=$mesactual;}




$mesactual_texto=veo_nombremes($mesactual);


// Esta Funcin calcula el ltimo da del (mes,ao) que le indiquemos
function ultimodia($mes,$ano){ 
    $ultimo_dia=28; 
    while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
       $ultimo_dia++; 
    } 
    return $ultimo_dia; 
} 

// Calculamos Cuantos das tiene el mes actual.
// Calculamos en que hueco del almanaque comienza el primer da del mes actual
$veoultimodia=ultimodia($mesactual,$yearactual);
$primerdiames=date('w', mktime(0,0,0,$mesactual,1,$yearactual)); 
if($primerdiames == 0){$primerdiames=7;}
$ultimodiames=date('w', mktime(0,0,0,$mesactual,$veoultimodia,$yearactual)); 
if($ultimodiames == 0){$ultimodiames=7;}

// Hacemos los clculos para rellenar los huecos del mes anterior
if($mesactual == 1){$anteriormes=12; $anterioryear=$yearactual-1;}else{$anteriormes=$mesactual-1; $anterioryear=$yearactual;}
$veoultimodia_anteriormes=ultimodia($anteriormes,$anterioryear);
if($primerdiames > 1){$numero_huecosanteriormes = $primerdiames - 1;}else{$numero_huecosanteriormes = 0;}
$primerdia_relleno_anteriormes=$veoultimodia_anteriormes - $numero_huecosanteriormes + 1;
$huecosanteriores = $primerdia_relleno_anteriormes;

// Hacemos los clculos para rellenar los huecos del prximo mes
if($mesactual == 12){$proximomes=1; $proximoyear=$yearactual+1;}else{$proximomes=$mesactual+1; $proximoyear=$yearactual;}
if($ultimodiames < 7){$numero_huecosproximomes = 7 - $ultimodiames;}



$numero_columnas_almanaque=7;
$estilo_dias_mesesadyacentes_almanaque="diasadyacentes_almanaque";
$estilo_dias_mesactuales_almanaque="diasactuales_almanaque";
$dia_con_evento_almanaque="dia_con_evento_almanaque";


$mesanterior=$mesactual-1;
$messiguiente=$mesactual+1;

$yearanterior=$yearactual;
$yearsiguiente=$yearactual;

if($mesanterior==0){
$mesanterior=12;
$yearanterior=$yearactual-1;
}
if($messiguiente==13){
$messiguiente=1;
$yearsiguiente=$yearactual+1;
}





echo '<div id="borde_sup_almanaque">';

	echo '<a href="'.$nombre_script.'?g=1&amp;mes_almanaque='.$mesanterior.'&amp;year_almanaque='.$yearanterior.'">';
	echo '<img src="imagenes/flecha-izq-calendario.png" class="left" alt="Mes Anterior" title="Mes Anterior" /></a>';
	
	echo '<span class="mes_year">'.$mesactual_texto."&nbsp;&nbsp;".$yearactual.'</span>';
	
	echo '<a href="'.$nombre_script.'?g=1&amp;mes_almanaque='.$messiguiente.'&amp;year_almanaque='.$yearsiguiente.'">';
	echo '<img src="imagenes/flecha-der-calendario.png" class="right" alt="Mes Siguiente" title="Mes Siguiente" /></a>';

echo '</div>';

//echo '<div id="cabecera_almanaque">'; // INICIO <div id="cabecera_almanaque">
//echo '</div>'; // FIN <div id="cabecera_almanaque"> 


echo '<div id="contenedor_tabla_dias">'; // INICIO: <div id="contenedor_tabla_dias">
echo '<table id="almanaque">';


echo '<tr> 
	<td class="nombredias_almanaque">'.$etq_dialunes.'</td>
	<td class="nombredias_almanaque">'.$etq_diamartes.'</td>
	<td class="nombredias_almanaque">'.$etq_diamiercoles.'</td>
	<td class="nombredias_almanaque">'.$etq_diajueves.'</td>
	<td class="nombredias_almanaque">'.$etq_diaviernes.'</td>
	<td class="nombredias_almanaque">'.$etq_diasabado.'</td>
	<td class="nombredias_almanaque">'.$etq_diadomingo.'</td>
</tr>';


$celda=1;
$fila=1;

for ($i = 1; $i <= $veoultimodia; $i++) {

if ($celda == 1){echo "<tr>";}

		if ($fila == 1){
				for ($celdasenblanco = 1; $celdasenblanco < $primerdiames; $celdasenblanco++) {
						$indice_problema = $huecosanteriores; $mes_indice_problema = $anteriormes; $year_indice_problema = $anterioryear; 
						$estilo_indice_problema = $estilo_dias_mesesadyacentes_almanaque;
						include('eventos/genero_celdas_almanaque.php'); 

					 $celda=$celda+1;
					 $huecosanteriores=$huecosanteriores+1;
				}
			$fila=$fila+1;
		}
			
			$indice_problema = $i; $mes_indice_problema = $mesactual; $year_indice_problema = $yearactual; 
			$estilo_indice_problema = $estilo_dias_mesactuales_almanaque;
			include('eventos/genero_celdas_almanaque.php'); 


if($i == $veoultimodia){ // RELLENOS LOS HUECOS DEL MES PRXIMO
	for ($huecosproximos = 1; $huecosproximos <= $numero_huecosproximomes; $huecosproximos++) {

			$indice_problema = $huecosproximos; $mes_indice_problema = $proximomes; $year_indice_problema = $proximoyear; 
			$estilo_indice_problema = $estilo_dias_mesesadyacentes_almanaque;
			include('eventos/genero_celdas_almanaque.php'); 

	}
if($huecosproximos>1){echo "</tr>";}
} 



if ($celda == 7){echo "</tr>"; $celda=0; $fila=$fila+1;}


	 $celda=$celda+1;

 }




echo '</table>';
echo '</div>'; // FIN <div id="contenedor_tabla_dias">

echo '<div id="borde_inf_almanaque">&nbsp;</div>';

?>