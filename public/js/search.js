/**
 * Created by rocio on 27/02/16.
 */
//var index = 0; //variable estática para controlar los index de los productos añadidos dinámicamente
//var apiKey = 'AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM';
var map;
var punto;
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
    initMap();

    $('.distancia').each(function(){
        var origen = $('#locate_user').val();
        var usuarioDestino = $(this).attr('id');
        var destino = $('.localizacion' + usuarioDestino).text();
        var nombreUsuario = $('#usuario' + usuarioDestino).text();
        //Forma 1 -> da error
        //No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://giftfinder.local' is therefore not allowed access.
        //http://stackoverflow.com/questions/13807052/origin-url-is-not-allowed-by-access-control-allow-origin-with-google-direction-a
        //var url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' + origen + '&destination=' + destino + '&key=' + apiKey;
        //Forma 2 -> Imposible hacerlo con ajax, da error:
        //No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://giftfinder.local' is therefore not allowed access.
        //http://stackoverflow.com/questions/13807052/origin-url-is-not-allowed-by-access-control-allow-origin-with-google-direction-a
        //Esta forma 2 da error, pero siguiendo la docu de Google, se consigue hacer con la
        //Forma 3:
        //https://developers.google.com/maps/documentation/javascript/directions#DisplayingResults
        var distancia = new google.maps.DirectionsService();
        punto = new google.maps.DirectionsRenderer();
        var peticionDistancia = { origin: origen, destination: destino, travelMode: google.maps.TravelMode.WALKING};
        distancia.route(peticionDistancia, function(results, status){
            if (status == google.maps.DirectionsStatus.OK){
                /*punto.setDirections(results);*/
                //Añadimos in marcador en el mapa para esta localización

                //var latitud = results.routes[0].legs[0].end_location.lat;
                //var longitud = results.routes[0].legs[0].end_location.lng;
                //Leer documentación acerca del objeto DirectionsRoute en https://developers.google.com/maps/documentation/javascript/directions#Routes
                var ubicacion = results.routes[0].legs[0].end_location;

                var marker = new google.maps.Marker({
                    position: ubicacion,
                    title: nombreUsuario,
                    label: labels[labelIndex++ % labels.length],
                    map: map
                }); // NO funciona, no añade nada
                //console.log('Añado a:' + nombreUsuario + 'en ' + +latitud + ' - ' + +longitud);
                /*var marker = new google.maps.Marker({
                    map: map,
                    // Define the place with a location, and a query string.
                    place: {
                        location: {lat: +latitud, lng: +longitud},
                        query: nombreUsuario

                    },
                });*/
                //Añadimos la distancia a la tabla
                $('#' + usuarioDestino).text(results.routes[0].legs[0].distance.text);

            }
        });
    });

});

/**
 * Función validar(latidud, longitud), según su valor numérico. Se cogen los datos de
 * partida de último post del hilo (mirar answered Apr 7 '14 at 4:52 Mosho):
 * http://stackoverflow.com/questions/22903756/using-regular-expression-to-validate-latitude-and-longitude-coordinates-then-dis
 */
function validar(latitud, longitud){

    var valido = true;

    if( typeof +latitud != 'number' || +latitud > 90 || +latitud < -90 ) {
        valido = false;
    }

    if( typeof +longitud != 'number' || +longitud > 180 || +longitud < -180 ) {
        valido = false;
    }
    return valido;

}
/**
 * Función mostrarError(error) que coloca la cadena pasada por parámetro en el
 * contenedor destinado a errores.
 *
 * @param {string} error
 */
function mostrarError(error) {
    limpiarErrores(); //Limpiamos toda la información que pueda haber antigua.
    var html = '<div id="contenedorErrores" class="alert alert-danger">' +
        '<strong>¡Atención!</strong> Hay algún problema con tu entrada.<br><br>' +
        '<ul>' +
        '<li>' + error + '</li>' +
        '</ul>' +
        '</div>';
    $('#errores').prepend(html);
}

/**
 * Función limpiar() que vacía todos los contenedores de información en el
 * fieldset de Predicción, gif de ajax, nombre de la ciudad, y lo deja limpio
 * para volcar la información actualizada que proceda.
 *
 */
/*function limpiar() {
    $('#latitud').val('');
    $('#longitud').val('');
    $('#localizacion').val('');
}
/**
 * Función limpiarErrores() que vacía el contenedor añadido para los mensajes
 * erróneod relacionados con eventos jquery.
 */
function limpiarErrores(){
    if ($('#contenedorErrores').length){
        $(this).html('');
    }
}

/*************************************************************************/
/*           FUNCIONES  RELACIONADAS CON BUSQUEDA DE PRODUCTOS           */
/*                                                                       */
/*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
/*************************************************************************/

function initMap(){
    /*var myLatLng = {lat: +$('#latitud_user').val(), lng: +$('#longitud_user').val()};

    var map = new google.maps.Map(document.getElementById('mapaBusquedas'), {
        zoom: 4,
        center: myLatLng
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Hello World!'
    });
    //Otra forma de marker:
     var marker = new google.maps.Marker({
         map: map,
         // Define the place with a location, and a query string.
         place: {
         location: {lat: latitud, lng: longitud},
         query: 'Aquí entregas/recoges tus productos'

         },
         // Attributions help users find your site again.
         attribution: {
         source: 'Google Maps JavaScript API',
         webUrl: 'https://developers.google.com/maps/'
     });
     }*/

    punto = new google.maps.DirectionsRenderer();
    var latitud = $('#latitud_user').val();
    var longitud = $('#longitud_user').val();
    var ubicacion = new google.maps.LatLng(+latitud,+longitud);
    /*var mapConfig = {
        zoom: 10,
        center: ubicacion
    };
    map = new google.maps.Map(document.getElementById('mapaBusquedas'), mapConfig);
    punto.setMap(map);*/
    map = new google.maps.Map(document.getElementById('mapaBusquedas'), {
        zoom: 10,
        center: ubicacion
    });

    var marker = new google.maps.Marker({
        position: ubicacion,
        title: 'Tú',
        label: labels[labelIndex++ % labels.length],
        map: map
    }); //Esta forma funciona, pero solo pinta el primer punto con etiqueta B!!

/*
    // Construct a new InfoWindow.
    var infoWindow = new google.maps.InfoWindow({
        content: 'Google Sydney'
    });

    // Opens the InfoWindow when marker is clicked.
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });*/

}