<?php

// ------------------- ENTRADA CON IMAGEN  ---------------------------
        echo '<div class="entrada">'; // INICIO: <div class="entrada">

			echo '<img src="data/fotos_noticias/'.$fotopequeportada.'" alt="'.$titulo.'" title="'.$titulo.'" />';
			
			//echo '<div class="fechaEntrada"><h4>'.$fechapublicacion.'</h4></div>';
            
            if($mostrar_tituloportada=="SI"){echo '<h1><a href="'.$url_amigable.'" title="'.$titulo.'">'.$titulo.'</a></h1>';}
                
			if($mostrar_titulo_subtitulo=="SI"){echo '<h2>'.$subtitulo.'</h2>';}
                
			if($mostrar_resumen=="SI"){echo '<p>'.$cadenaproblema.'</p>';}
			
        echo '</div>'; // FIN: <div class="entrada">

// ------------------- FIN ENTRADA CON IMAGEN  ---------------------------
?>