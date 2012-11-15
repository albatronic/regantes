<?php

			include("comunes/load-head.php");   


			$f1="eventos";
			$_SESSION['act_pag']=$nombre_script;
			$spp=$codigomd5seccion_49;
			$_SESSION['sesion_spp']=$spp;

			$diaactual_evento=substr($fecha_evento,8,2);
			$mesactual_evento=substr($fecha_evento,5,2);
			$yearactual_evento=substr($fecha_evento,0,4);


			include("dmntr/contadorvisitas_urlamigables/contadorvisitas.php");   

			$seccion_problema=$spp;
			
			include("noticias/cabecera_listado_noticias.php");   


			include("imagenesdesign/vemos_imagenesdesign_fijas.php");
			include("imagenesdesign/vemos_imagendesign_asociada_seccion.php");   

			include("comunes/consulto_metatags.php");   
			include("comunes/metatags.php");   

			


				include("estilos/estilos-eventos.php");     
				include("js/javascript-eventos.php");    

?>