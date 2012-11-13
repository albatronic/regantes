<?php

if (strlen($indice_problema)==1){$dia_problema="0".$indice_problema;}else{$dia_problema=$indice_problema;}
if (strlen($mes_indice_problema)==1){$mes_problema="0".$mes_indice_problema;}else{$mes_problema=$mes_indice_problema;}
$fecha_problema=$year_indice_problema."-".$mes_problema."-".$dia_problema;

$sql="select id_almanaqueevento from almanaqueeventos where fechaevento='$fecha_problema'";
$res=mysql_query($sql,$db);
$total_eventos_fecha_problema=mysql_num_rows($res);
if($fecha_problema=="2012-10-17"){$total_eventos_fecha_problema=5;}
if($fecha_problema=="2012-10-02"){$total_eventos_fecha_problema=5;}
if($fecha_problema=="2012-10-28"){$total_eventos_fecha_problema=5;}
if($fecha_problema=="2012-03-31"){$total_eventos_fecha_problema=5;}
if($fecha_problema=="2012-05-01"){$total_eventos_fecha_problema=5;}

if($total_eventos_fecha_problema == 0){
echo '<td class="'.$estilo_indice_problema.'">';
echo $indice_problema;
echo "</td>";
}else{

		include('eventos/analizo_eventos_publicosprivados.php'); 
if($fecha_problema=="2012-10-17"){$recuento_contenidos_fecha_problema=5;}
if($fecha_problema=="2012-10-02"){$recuento_contenidos_fecha_problema=5;}
if($fecha_problema=="2012-10-28"){$recuento_contenidos_fecha_problema=5;}
if($fecha_problema=="2012-03-31"){$recuento_contenidos_fecha_problema=5;}
if($fecha_problema=="2012-05-01"){$recuento_contenidos_fecha_problema=5;}

if($recuento_contenidos_fecha_problema>0){
$estilo_indice_problema=$dia_con_evento_almanaque;
}

echo '<td class="'.$estilo_indice_problema.'">';
if($iuweb > 0){$codigomd5seccion_2=$codigomd5seccion_5;}		

if($recuento_contenidos_fecha_problema>0){
if(strlen($indice_problema)<2){$texto_indice_problema="0".$indice_problema;}else{$texto_indice_problema=$indice_problema;}
//echo '<a href="agenda.php?fecha_evento='.$fecha_problema.'">';
echo '<a href="eventos-'.$yearactual.'-'.$mes_problema.'-'.$texto_indice_problema.'.php">';
echo $indice_problema;
echo "</a>";
}else{
echo $indice_problema;
}

echo "</td>";
}

?>