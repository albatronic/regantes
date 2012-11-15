<?php

echo '<table cellspacing="1" cellpadding="0" border="0">';

//echo '<tr><td id="almanaque_espacio_superior" colspan="'.$numero_columnas_almanaque.'"></td></tr>'; 

/*echo '<tr><td id="almanaque_mes" colspan="'.$numero_columnas_almanaque.'">';
echo $mesactual_texto." ".$yearactual;
echo '</td></tr>'; */

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

					 //echo "<td class='$estilo_dias_mesesadyacentes_almanaque'>$huecosanteriores</td>"; 
					 $celda=$celda+1;
					 $huecosanteriores=$huecosanteriores+1;
				}
			$fila=$fila+1;
		}
			
			$indice_problema = $i; $mes_indice_problema = $mesactual; $year_indice_problema = $yearactual; 
			$estilo_indice_problema = $estilo_dias_mesactuales_almanaque;
			include('eventos/genero_celdas_almanaque.php'); 

			 //echo "<td class='$estilo_dias_mesactuales_almanaque' align='center'>".$i."</td>";

if($i == $veoultimodia){ // RELLENOS LOS HUECOS DEL MES PRXIMO
	for ($huecosproximos = 1; $huecosproximos <= $numero_huecosproximomes; $huecosproximos++) {

			$indice_problema = $huecosproximos; $mes_indice_problema = $proximomes; $year_indice_problema = $proximoyear; 
			$estilo_indice_problema = $estilo_dias_mesesadyacentes_almanaque;
			include('eventos/genero_celdas_almanaque.php'); 

			//echo "<td class='$estilo_dias_mesesadyacentes_almanaque' align='center'>".$huecosproximos."</td>";
	}
if($huecosproximos>1){echo "</tr>";}
} 



if ($celda == 7){echo "</tr>"; $celda=0; $fila=$fila+1;}
//if ($celda == 7){$celda=0; $fila=$fila+1;}


	 $celda=$celda+1;

 }

/*
echo '<tr><td id="siguiente_anterior_almanaque" colspan="'.$numero_columnas_almanaque.'">';

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

echo '<a href="index.php?g=1&amp;c='.$c.'&amp;c2='.c2.'&amp;f1='.$f1.'&amp;s1='.$s1.'&amp;f2='.$f2.'&amp;s2='.$s2.'&amp;mes_almanaque='.$mesanterior.'&amp;year_almanaque='.$yearanterior.'&amp;sp='.$sp.'&amp;spp='.$spp.'&amp;cp='.$cp.'&amp;fecha_evento='.$fecha_evento.'">';
echo '&lt;&lt;';
echo '</a>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;';
echo '<a href="index.php?g=1&amp;c='.$c.'&amp;c2='.$c2.'&amp;f1='.$f1.'&amp;s1='.$s1.'&amp;f2='.$f2.'&amp;s2='.$s2.'&amp;mes_almanaque='.$messiguiente.'&amp;year_almanaque='.$yearsiguiente.'&amp;sp='.$sp.'&amp;spp='.$spp.'&amp;cp='.$cp.'&amp;fecha_evento='.$fecha_evento.'">';
echo '&gt;&gt;';
echo '</a>';

echo '</td></tr>';  */



echo '</table>';
?>