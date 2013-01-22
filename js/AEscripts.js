/* 
 * @author Sergio Pérez <sergio.perez@albatronic.com>
 * @copyright Ártico Estudio, sl
 * @version 1.0 27-nov-2012
 */


/*
 * CALENDARIO AE
 *
 */

var meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

$(document).ready(function(){
    
    $('#calendarioBotonAnterior').click(
        function(){
            var mes = parseInt( $('#calendarioMesActual').val() );
            var ano = parseInt( $('#calendarioAnoActual').val() );
            
            mes = mes - 1;
            if (mes <= 0) {
                mes = 12;
                ano = ano - 1;
            }
            
            calendario('calendarioTablaDias',mes,ano);
            
            $('#calendarioMesActual').val(mes);
            $('#calendarioAnoActual').val(ano);    
        }
        );

    $('#calendarioBotonSiguiente').click(
        function(){
            var mes = parseInt( $('#calendarioMesActual').val() );
            var ano = parseInt( $('#calendarioAnoActual').val() );
            
            mes = mes + 1;
            if (mes >= 13) {
                mes = 1;
                ano = ano + 1;
            }            

            calendario('calendarioTablaDias',mes,ano);
            
            $('#calendarioMesActual').val(mes);
            $('#calendarioAnoActual').val(ano);    
        }
        );   
            
            
	$("a[rel='pop-up']").click(function () {
	var caracteristicas = "height="+(screen.availHeight - 40)+",width="+(screen.availWidth - 13)+",screenX=0,screenY=0,left=0,top=0,status=no,menubar=yes,scrollbars=yes,resizable=yes,toolbar=yes,location=yes";
	nueva=window.open(this.href, 'Popup', caracteristicas);
	return false;
	});            

});

   
/**
 * Genera el html con el calendario del 'mes' y 'ano'
 * y lo pone dentro del div 'idDiv'
 */
function calendario(idDiv,mes,ano) {
    var url        = appPath + '/lib/calendario.php';
    var parametros = 'mes='+mes+'&ano='+ano;

    // Coloco un gif "Cargando..." en la capa
    $('#'+idDiv).html("<img src='"+appPath+"/images/loading.gif'>");

    // Pintar el literal del mes y año
    jQuery('#calendarioTextoMes').html(meses[mes-1] + " " + ano);
    // Pintar el calendario
    jQuery('#'+idDiv).load(url, parametros);
    
}

/**
 * Captura la resolucion del dispositivo de navegación del cliente web y 
 * se la envía por ajax a lib/setResolucion.php para que la ponga en $_SESSION['resolucionVisitante']
 */
function chequeaResolucionVisitante() {
    
    var ventana_ancho = screen.width;
    var ventana_alto = screen.height;
    var var_resolucion = ventana_ancho+'x'+ventana_alto;
    var navInfo = window.navigator.appVersion.toLowerCase();
        
    //alert (var_resolucion);
    
    $.ajax({
        url: 'lib/setResolucion.php',
        type: 'POST',
        async: true,
        data: {
            navegador:navInfo,
            resolucion:var_resolucion
        }
    })
}


/**
 * Scripts para Twitter
 */
$(document).ready(function(){
        $(".tweet").tweet({ // Aquí indicamos donde poner los tweets, le pondremos un div vacio con clase .tweets
            username: "{{values.twitter.idUsuario}}", // el usuario
            avatar_size: "{{values.twitter.mostrarAvatar}}", // Ponle 0 si no quieres avatares
            count: "{{values.twitter.numeroItems}}", // Numero de tweets
            loading_text: "{{values.twitter.mensaje}}" // Mensaje que se muestra mientras se cargan los tweets
        });
    });
