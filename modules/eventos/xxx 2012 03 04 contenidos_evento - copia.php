<?php

if($iuweb > 0){		
$sql="select num_contenido_md5,num_secciondecontenidos_md5,titulo,subtitulo,resumen,mostrar_titulo_subtitulo,fotograndeportada,fotopequeportada,fotominiportada,mostrarfotosportada,dise_mini_portada,mostrar_resumen,fondo_noticia_resaltado,posicion_foto_noticia,url_amigable from contenidos_v2 where num_contenido_md5='$num_contenido_md5_evento' and publicar='SI' and es_privado='SI'";
}else{
$sql="select num_contenido_md5,num_secciondecontenidos_md5,titulo,subtitulo,resumen,mostrar_titulo_subtitulo,fotograndeportada,fotopequeportada,fotominiportada,mostrarfotosportada,dise_mini_portada,mostrar_resumen,fondo_noticia_resaltado,posicion_foto_noticia,url_amigable from contenidos_v2 where num_contenido_md5='$num_contenido_md5_evento' and publicar='SI' and es_privado='NO'";
}


		$res=mysql_query($sql,$db);
		while ($reg=mysql_fetch_array($res))
		{ // INICIO: while select ____________________________________________________________________
				//$num_contenido=$reg[1];
				$num_contenido_md5=$reg['num_contenido_md5'];
				$num_secciondecontenidos_md5=$reg['num_secciondecontenidos_md5'];
				//$num_departamento_md5=$reg[4];
				//$num_tipodecontenido=$reg[5];
				//$num_tipodecontenido_md5=$reg[6];
				//$mostrar_diseno_cabecera_titulo=$reg[7];
				$titulo=$reg['titulo'];
				$subtitulo=$reg['subtitulo'];
				$resumen=$reg['resumen'];
				//$contenido=$reg[11];
				//$ruta_almacenamiento=$reg[12];
				//$es_ficheroexterno=$reg[13];
				//$nombreficheroexterno=$reg[14];
				//$extensionficheroexterno=$reg[15];
				//$ruta_almacenamiento_ficheroexterno=$reg[16];
				//$tienealbumdefotos=$reg[17];
				//$num_albumdefotos_md5=$reg[18];
				//$posicion_albumdefotos=$reg[19];
				//$tieneenlacesdeinteres=$reg[20];
				//$num_seccion_enlacesdeinteres_md5=$reg[21];
				//$tienecontenidosrelacionados=$reg[22];
				//$tieneficherosadjuntos=$reg[23];
				//$num_seccionficherosadjuntos_md5=$reg[24];
				//$es_noticia=$reg[25];
				//$publicarcomonoticia=$reg[26];
				//$tiene_desarrollo_noticia=$reg[27];
				//$es_evento=$reg[28];
				//$fechaevento=$reg[29];
				//$estoyinteresado=$reg[30];
				//$email_recepcion_aviso=$reg[31];
				//$ancho_contenedor=$reg[32];
				//$es_privado=$reg[33];
				//$numeroenvios_a_amigos=$reg[34];
				//$numerodevisitas=$reg[35];
				//$orden=$reg[36];
				//$publicar=$reg[37];
				//$esdatopredeterminado=$reg[38];
				//$es_de_superadministrador=$reg[39];
				//$solo_visible_para_superadministrador=$reg[40];
				//$fechapublicacion=$reg[41];
				//$usuariopublicacion=$reg[42];
				//$fechaultimamodificacion=$reg[43];
				//$usuarioultimamodificacion=$reg[44];
				//$fechaactivar=$reg[45];
				//$fechadesactivar=$reg[46];
				//$mostrar_cabecera_en_contenido=$reg[47];
				//$palabras_clave=$reg[48];
				//$mostrar_nombre_seccion=$reg[49];
				$mostrar_titulo_subtitulo=$reg['mostrar_titulo_subtitulo'];
				//$mostrar_fechapublicacion=$reg[51];
				//$albumdefotos_int_ext=$reg[52];
				//$num_albumdefotos_md5_externo=$reg[53];
				//$publicar_albumdefotos=$reg[54];
				//$orden_comonoticia=$reg[55];
				//$horaevento=$reg[56];
				//$fechapublicacion_bd=$reg[57];
				//$es_hemeroteca=$reg[58];
				//$num_mediocomunicacion=$reg[59];
				//$num_idioma=$reg[60];
				//$nombrefichero_disenocabecera=$reg[61];
				//$ruta_almacenamiento_disenocabecera=$reg[62];
				$fotograndeportada=$reg['fotograndeportada'];
				$fotopequeportada=$reg['fotopequeportada'];
				$fotominiportada=$reg['fotominiportada'];
				$mostrarfotosportada=$reg['mostrarfotosportada'];
				$dise_mini_portada=$reg['dise_mini_portada'];
				//$mostrar_enlacesdeinteres=$reg[68];
				//$mostrar_ficherosadjuntos=$reg[69];

				$mostrar_resumen=$reg['mostrar_resumen'];
				$fondo_noticia_resaltado=$reg['fondo_noticia_resaltado'];
				$posicion_foto_noticia=$reg['posicion_foto_noticia'];
				$url_amigable=$reg['url_amigable'];



				decode_gestorcontenidos($resumen);
				$resumen=$resultado;
				
				$cadenaproblema=$resumen;


echo '<div class="cada_noticia_portada">'; // INICIO: <div class="cada_noticia_portada">______________________________


if(strlen(trim($fotopequeportada))>0){
	if($mostrarfotosportada=="SI"){
		$noticia_con_foto="SI";
	}
}

$mostrar_tituloportada='SI';
$mostrar_titulo_subtitulo='SI';
$mostrar_resumen='SI';

if($noticia_con_foto=="SI"){
echo '<div class="foto_noticia">';
	echo '<img src="data/fotos_noticias/'.$fotopequeportada.'" alt="'.$titulo.'" />';
echo '</div>';

echo '<div class="texto_noticia">';
		if(strlen(trim($titulo))<1){$mostrar_tituloportada='NO';}
		if($mostrar_tituloportada=='SI'){ 
			echo '<h1><a href="'.$url_amigable.'">'.$titulo.'</a></h1>';
		}
		
		if(strlen(trim($subtitulo))<1){$mostrar_titulo_subtitulo='NO';}
		if($mostrar_titulo_subtitulo=='SI'){ 
			echo '<h2>'.$subtitulo.'</h2>';
		}
		
		
		if(strlen(trim($cadenaproblema))<1){$mostrar_resumen='NO';}
		if($mostrar_resumen=='SI'){ 
			echo '<p>'.$cadenaproblema.'</p>';
		}
echo '</div>';

}else{

		echo '<div class="noticia_sin_foto">';
				if(strlen(trim($titulo))<1){$mostrar_tituloportada='NO';}
				if($mostrar_tituloportada=='SI'){ 
					echo '<h1><a href="'.$url_amigable.'">'.$titulo.'</a></h1>';
				}
				
				if(strlen(trim($subtitulo))<1){$mostrar_titulo_subtitulo='NO';}
				if($mostrar_titulo_subtitulo=='SI'){ 
					echo '<h2>'.$subtitulo.'</h2>';
				}
				
				
				if(strlen(trim($cadenaproblema))<1){$mostrar_resumen='NO';}
				if($mostrar_resumen=='SI'){ 
					echo '<p>'.$cadenaproblema.'</p>';
				}
		echo '</div>';

}








	$cadenaproblema="";



echo '</div>'; // FIN: <div class="cada_noticia_portada">______________________________

echo '<div class="separacion_cada_noticia_portada"></div>';




} // FIN: while select ____________________________________________________________________

?>