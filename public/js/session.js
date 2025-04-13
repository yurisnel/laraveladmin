/**
 * Función para cerrar sesión automáticamente.
 * Por defecto sería 60 minutos y después 1 minuto para cerrar. 
 *  3600 = 60 minutos  
 */
(function($)
{
    var tiempoSesion = 0;
    var tiempoModal = 3600;
    var tiempoCierreFinal = 3660;
    setInterval(function(){ 
        if(tiempoSesion == tiempoModal){
            $("#modal-cerrar-sesion").modal("show");
        }
        if(tiempoSesion == tiempoCierreFinal){
            document.getElementById('logout-form').submit();
        }
        tiempoSesion++;
    }, 1000);

    

    $( "body" ).mousemove(function() {
        tiempoSesion = 0;
    });

})(jQuery);