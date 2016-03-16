/**
 * Script jQuery para gestionar eventos y demás contenido dinámico de la aplicación,
 * específicamente de la página de búsquedas.
 *
 * Created by rocio on 27/02/16.
 */
var map;
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = -1;

$(function(){

    /*
     Inicializando las tooltips de bootstrap para indicaciones sobre algunos campos del formulario.
     */
    $('input[rel="txtTooltip"]').tooltip();
    $('select[rel="txtTooltip"]').tooltip();
    $('a[rel="txtTooltip"]').tooltip();
    $('button[rel="txtTooltip"]').tooltip();
    $('textarea[rel="txtTooltip"]').tooltip();

    /*
     Inicializamos la ordenación de la tabla con dataTable, tal como se indica en:
     http://www.codeproject.com/Tips/823490/Bootstrap-Table-With-Sorting-Searching-and-Paging
     */
    //TODO no funciona precisamente con la columna de distancias, que es la que interesa que se ordene.
    //Usado según https://datatables.net/ con el código de labels en español.
    $('#resultados').dataTable({
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



    /*************************************************************************/
    /*             EVENTOS RELACIONADOS CON PANTALLA BÚSQUEDA                */
    /*                                                                       */
    /*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
    /*************************************************************************/
    initMap(); //Iniciamos el mapa donde se van a cargar los puntos de geoposicionamiento.

    //Por cada linea de la tabla de resultados, calculamos la distancia hasta el usuario logado
    //y pintamos un marker en el mapa, tras localizar latitud/longitud.
    $('.distancia').each(function(){

        //Cargamos las variables con los datosde origen y destino de los diferentes usuarios sobre los que hay
        //que calcular la distancia.
        var origen = $('#locate_user').val();
        var usuarioDestino = $(this).attr('id');
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
        //Esta forma 2 da error, pero siguiendo la docu de Google, se consigue hacer con el siguiente algoritmo.

        /********* FORMA DE HACERLO **********/
        //Forma 3:
        //https://developers.google.com/maps/documentation/javascript/directions#DisplayingResults
        var distancia = new google.maps.DirectionsService();
        var peticionDistancia = { origin: origen, destination: destino, travelMode: google.maps.TravelMode.WALKING};
        distancia.route(peticionDistancia, function(results, status){
            if (status == google.maps.DirectionsStatus.OK){

                //Añadimos in marcador en el mapa para esta localización

                //Documentación acerca del objeto DirectionsRoute en https://developers.google.com/maps/documentation/javascript/directions#Routes
                var ubicacion = results.routes[0].legs[0].end_location;

                //Por cada
                var marker = new google.maps.Marker({
                    position: ubicacion,
                    title: nombreUsuario,
                    label: labels[labelIndex++ % labels.length],
                    map: map
                });

                //Añadimos la distancia a la tabla
                $('#' + usuarioDestino).text(results.routes[0].legs[0].distance.text);

            }
        });
    });

});


/*************************************************************************/
/*           FUNCIONES  RELACIONADAS CON BUSQUEDA DE PRODUCTOS           */
/*                                                                       */
/*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
/*************************************************************************/

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