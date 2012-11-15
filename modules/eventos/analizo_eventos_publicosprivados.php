<?php

$recuento_contenidos_fecha_problema=0;

$sqleventos="select num_contenido_md5 from eventos where fechaevento='$fecha_problema'";
$reseventos=mysql_query($sqleventos,$db);
while ($regeventos=mysql_fetch_array($reseventos))
{ 
$num_contenido_md5_evento=$regeventos['num_contenido_md5'];


if($iuweb > 0){		
$sqlcontenidos="select id_contenido from contenidos_v2 where num_contenido_md5='$num_contenido_md5_evento' and publicar='SI' and es_privado='SI'";
$rescontenidos=mysql_query($sqlcontenidos,$db);
$total_contenidos_fecha_problema=mysql_num_rows($rescontenidos);
$recuento_contenidos_fecha_problema=$recuento_contenidos_fecha_problema+$total_contenidos_fecha_problema;
}else{
$sqlcontenidos="select id_contenido from contenidos_v2 where num_contenido_md5='$num_contenido_md5_evento' and publicar='SI' and es_privado='NO'";
$rescontenidos=mysql_query($sqlcontenidos,$db);
$total_contenidos_fecha_problema=mysql_num_rows($rescontenidos);
$recuento_contenidos_fecha_problema=$recuento_contenidos_fecha_problema+$total_contenidos_fecha_problema;
}


}
		

?>