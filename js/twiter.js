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


