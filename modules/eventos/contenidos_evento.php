<?php

$sql="select num_contenido,num_contenido_md5,num_secciondecontenidos_md5,titulo,subtitulo,resumen,fechapublicacion,mostrar_titulo_subtitulo,fotograndeportada,fotopequeportada,fotominiportada,mostrarfotosportada,dise_mini_portada,mostrar_resumen,fondo_noticia_resaltado,posicion_foto_noticia,mostrar_tituloportada,url_amigable from contenidos_v2 where num_contenido_md5='$num_contenido_md5_evento' and publicar='SI' and eliminado='NO'";

$res=mysql_query($sql,$db);
while ($reg=mysql_fetch_array($res))

{ // INICIO: while select ____________________________________________________________________
				$num_contenido=$reg['num_contenido'];
				$num_contenido_md5=$reg['num_contenido_md5'];
				$num_secciondecontenidos_md5=$reg['num_secciondecontenidos_md5'];
				$titulo=$reg['titulo'];
				$subtitulo=$reg['subtitulo'];
				$resumen=$reg['resumen'];
				$fechapublicacion=$reg['fechapublicacion'];
				$mostrar_titulo_subtitulo=$reg['mostrar_titulo_subtitulo'];
				$fotograndeportada=$reg['fotograndeportada'];
				$fotopequeportada=$reg['fotopequeportada'];
				$fotominiportada=$reg['fotominiportada'];
				$mostrarfotosportada=$reg['mostrarfotosportada'];
				$dise_mini_portada=$reg['dise_mini_portada'];
				$mostrar_resumen=$reg['mostrar_resumen'];
				$fondo_noticia_resaltado=$reg['fondo_noticia_resaltado'];
				$posicion_foto_noticia=$reg['posicion_foto_noticia'];
				$mostrar_tituloportada=$reg['mostrar_tituloportada'];
				$url_amigable=$reg['url_amigable'];


				$cadenaproblema=$resumen;

$fechahora_problema=$fechapublicacion; include('dmntr/funciones/decodificofechahora.php'); $fechapublicacion=$fecha_decode;

if(strlen(trim($fotopequeportada))>0){
	if($mostrarfotosportada=="SI"){
		$noticia_con_foto="SI";
	}
}else{$mostrarfotosportada="NO"; $noticia_con_foto="NO";}

if(strlen(trim($titulo))<1){$mostrar_tituloportada='NO';}

if(strlen(trim($subtitulo))<1){$mostrar_titulo_subtitulo='NO';}

if(strlen(trim($cadenaproblema))<1){$mostrar_resumen='NO';}


if($noticia_con_foto=="SI"){ 
include('eventos/listadoNoticiasConFoto.php'); 
}else{
include('eventos/listadoNoticiasSinFoto.php'); 
}

	$cadenaproblema="";


} // FIN: while select ____________________________________________________________________
?>