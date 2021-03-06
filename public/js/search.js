/**
 * Script jQuery para gestionar eventos y demás contenido dinámico de la aplicación,
 * específicamente de la página de búsquedas.
 *
 * Created by rocio on 27/02/16.
 */
var map;
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = -1;
var listaDistancias = [];

$(function(){

    /*
     Inicializando las tooltips de bootstrap para indicaciones sobre algunos campos del formulario.
     */
    $('input[rel="jslicense"]').tooltip();
    $('select[rel="jslicense"]').tooltip();
    $('a[rel="jslicense"]').tooltip();
    $('button[rel="jslicense"]').tooltip();
    $('textarea[rel="jslicense"]').tooltip();



    /*************************************************************************/
    /*             EVENTOS RELACIONADOS CON PANTALLA BÚSQUEDA                */
    /*                                                                       */
    /*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
    /*************************************************************************/
    initMap(); //Iniciamos el mapa donde se van a cargar los puntos de geoposicionamiento.

    //Por cada linea de la tabla de resultados, calculamos la distancia hasta el usuario logado
    //y pintamos un marker en el mapa, tras localizar latitud/longitud.
    $('.distancia').each(function(){
        //Cargamos la lista con las promesas que nos facilita la función predefinida.
        //Según el ejemplo en:
        //http://stackoverflow.com/questions/9044468/wait-for-each-to-finish-given-each-has-ajax-calls
        listaDistancias.push(cargaDistancia($(this)));
    });

    //Cuando la lista de promesas esté completa, formateamos la tabla, antes, no.
    $.when.apply($, listaDistancias).done(formateaTabla);
});


/*************************************************************************/
/*           FUNCIONES  RELACIONADAS CON BUSQUEDA DE PRODUCTOS           */
/*                                                                       */
/*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
/*************************************************************************/

function cargaDistancia(elemento){

    //Usamos promesas para alimentar la lista de distancias y evitar que el proceso asíncrono
    //nos formatee la tabla antes de cargar los datos (de esa forma no ordenaría por distancias,
    //que es precisamente la columna que más interesa ordenar).
    var promesa = $.Deferred();

    //Cargamos las variables con los datos de origen y destino de los diferentes usuarios sobre los que hay
    //que calcular la distancia.
    var origen = $('#locate_user').val();
    var usuarioDestino = elemento.attr('id');
    var destino = $('.localizacion' + usuarioDestino).text();
    var nombreUsuario = $('#usuario' + usuarioDestino).text();

    /********* FORMAS DE NO HACER ESTO  *****/
    //Forma 1 -> da error
    //No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://giftfinder.local' is therefore not allowed access.
    //http://stackoverflow.com/questions/13807052/origin-url-is-not-allowed-by-access-control-allow-origin-with-google-direction-a
    //var url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' + origen + '&destination=' + destino + '&key=' + apiKey;
    //Forma 2 -> Imposible hacerlo con ajax, da error:
    //No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://giftfinder.local' is therefore not allowed access.
    //http://stackoverflow.com/questions/13807052/origin-url-is-not-allowed-by-access-control-allow-origin-with-google-direction-a
    //Esta forma 2 da error, pero siguiendo la doc de Google, se consigue hacer con el siguiente algoritmo.

    /********* FORMA DE HACERLO **********/
    //Forma 3:
    //https://developers.google.com/maps/documentation/javascript/directions#DisplayingResults
    var distancia = new google.maps.DirectionsService();
    var peticionDistancia = { origin: origen, destination: destino, travelMode: google.maps.TravelMode.WALKING};
    distancia.route(peticionDistancia, function(results, status){
        if (status == google.maps.DirectionsStatus.OK){

            //Añadimos un marcador en el mapa para esta localización

            //Documentación acerca del objeto DirectionsRoute en https://developers.google.com/maps/documentation/javascript/directions#Routes
            var ubicacion = results.routes[0].legs[0].end_location;

            //Por cada
            var marker = new google.maps.Marker({
                position: ubicacion,
                title: nombreUsuario,
                label: labels[labelIndex++ % labels.length],
                map: map
            });

            //Añadimos la distancia a la tabla, nos conviene mostrarla en kilometros numéricamente, para poderla
            //ordenar en la parrilla de salida de datos.
            //Esta opción nos mostraría la distancia en km de forma alfanumérica, p.e. 18.5 km o en metros, 2 m
            //$('#' + usuarioDestino).text(results.routes[0].legs[0].distance.text);
            //Pero value contiene la distancia en metros, con lo que la convertimos siempre a km y la mostramos:
            $('#' + usuarioDestino).text(Math.round(results.routes[0].legs[0].distance.value)/1000);

        }
        promesa.resolve(); //Indicamos al destinatario de la promesa que hemos terminado el cálculo.
    });
    return promesa.promise(); //Lo que retornamos a la lista de distancias es la promesa de que vamos a facilitar el dato en breve.
}

function formateaTabla(){
    /*
     Inicializamos la ordenación de la tabla con dataTable, tal como se indica en:
     http://www.codeproject.com/Tips/823490/Bootstrap-Table-With-Sorting-Searching-and-Paging
     */
    //Usado según https://datatables.net/ con el código de labels en español.
    $('#resultados').dataTable({
        "aaSorting": [[6,'asc']],
        "language":{
            "processing":     "Procesando...",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "zeroRecords":    "No se encontraron resultados",
            "emptyTable":     "Ningún dato disponible en esta tabla",
            "info":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "infoPostFix":    "",
            "search":         "Buscar:",
            "url":            "",
            "infoThousands":  ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first":    "Primero",
                "last":     "Último",
                "next":     "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "aortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
}
/**
 * Carga el mapa tomando como centro al ubicación del usuario logado, y marca un
 * marker con la letra A en el sitio donde está el usuario.
 * El zoom se sitúa en 10, que por lo general permite ver más de una ciudad
 * en el mismo recuadro.
 */
function initMap(){

    //Documentación en https://developers.google.com/maps/documentation/javascript/directions#DisplayingResults
    var latitud = $('#latitud_user').val();
    var longitud = $('#longitud_user').val();
    var ubicacion = new google.maps.LatLng(+latitud,+longitud);

    map = new google.maps.Map(document.getElementById('mapaBusquedas'), {
        zoom: 10,
        center: ubicacion
    });

    var marker = new google.maps.Marker({
        position: ubicacion,
        title: 'Tú',
        label: labels[labelIndex++ % labels.length],
        map: map
    }); //Esta forma funciona, y pinta el punto donde está el usuario logado.

}