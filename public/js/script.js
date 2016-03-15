/**
 * Created by rocio on 27/02/16.
 */
var index = 0; //variable estática para controlar los index de los productos añadidos dinámicamente
var apiKey = 'AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM';
var map;
$(function(){
    /*************************************************************************/
    /*                EVENTOS RELACIONADOS CON PERFIL DE USUARIO             */
    /*************************************************************************/

    /*
    Por cada producto cargado creamos un evento asociado al botón de borrar producto, para eliminar la
    fila completa de combos asociados a ese producto en concreto
     */
    $('a.borrarProducto').each(function(){
        $(this).click(function(){
            var elem = '#productoCompartido' + $(this).attr('id') + ' option';
            $(elem).each(function(){
                //Para forzar que nos borre el producto de la base de datos, inicializamos a 'Producto'
                if ($(this).text() == 'Producto'){
                    $(this).attr('selected', 'selected');
                }else{
                    $(this).removeProp('selected');
                }
            });
            //Ocultamos la fila de combos usando una clase con el id ligado al producto (x+ index)
            var ocultos = '.' + $(this).attr('id');
            $(ocultos).each(function(){
                $(this).hide();
            });
        });
    });
    /*
    Asociamos un evento change a cada linea productoNuevo, para que oculte el botón + en caso de que
    el combo no tenga seleccionado ningún producto.
    TODO No funciona correctamente, solo asocia el evento al primer elemento, no a todos.
     */
    $('.productoNuevo').each(function(){
        $(this).change(function(){
            if ($(this).val() != 'Producto'){
                $('#mas').removeClass('hidden');
                index++;
                $(this).attr('id', 'productoNuevox' + index);
                $(this).attr('name', 'producto[' + index + ']');
            }else{
                $('#mas').addClass('hidden');
            }
        });
    });

    /*
    Añade otra línea de artículos al pulsar +
     */
    $('#mas').click(function(){
        var nuevaLinea = $('#nuevaLinea').html();
        //Recuperamos el código html correpondiente a una línea extra del propio documento
        $('#fin').before(nuevaLinea);
        //Cambiamos el index, para evitar id duplicados.
        $('.penultima a.borrarProducto').attr('id', 'x' + index);
        //Cambiamos las clases penultimas por el id de la linea nueva, para asociarla al borrado de linea si se pulsa
        $('.penultima').addClass('x' + index).removeClass('penultima');
        //Asociamos un evento para ocultar esta linea al botón de borrado, usando la clase recién creada.
        $('div.x' + index + ' a.borrarProducto').click(function(){
            var elem = '#productoNuevo' + $(this).attr('id');
            //Paso 1: Reiniciar el valor del producto a 'Producto', para que el controller lo ignore al grabar.
            $(elem).val('Producto');
            //Paso 2: ocultar todos los divs con el id asociado a la linea
            var ocultos = '.' + $(this).attr('id');
            $(ocultos).each(function(){
                $(this).hide();
            });
        });
        //Cambiamos las clases de ultima a penultima, para dejarlo listo por si se genera una linea nueva después.
        $('.ultima').addClass('penultima').removeClass('ultima');
        $('#mas').addClass('hidden'); //Hay que ocultar el boton mas, mientras que no se cambie el valor de 'Producto'
    });

    /*
    Gestión de evento click para visualización de caja modal para confirmación de borrado de perfil en el sitio
     */
    $('#enviar').on('click', function(e){
        if($('#eliminar').prop('checked')){
            e.preventDefault();
            $('#confirmacion').modal({ backdrop: 'static', keyboard: false })
                .one('click', '#borrar', function() {
                    $('#perfil').trigger('submit');
                });
        }else if(!$('#checkMap').prop('checked')){
            e.preventDefault();
            $('#confirmaPosicion').modal('show');
        }
    });

    /*
     Inicializando las tooltips de bootstrap para indicaciones sobre algunos campos del formulario.
     */
    $('input[rel="txtTooltip"]').tooltip();
    $('select[rel="txtTooltip"]').tooltip();
    $('a[rel="txtTooltip"]').tooltip();
    $('button[rel="txtTooltip"]').tooltip();
    $('textarea[rel="txtTooltip"]').tooltip();

    /*************************************************************************/
    /*                EVENTOS RELACIONADOS CON PANEL DE CONTROL              */
    /*************************************************************************/

    $('.eliminar').click(function(e) {
        e.preventDefault();
        //Guardamos la url a la que tenemos que redirigir la página en caso de confirmación:
        var url = $(this).attr('href');
        var desgloseUrl = url.split('/');
        //Con estos datos inyectamos valores al cuadro modal:
        $('#borraRegistro').val(desgloseUrl[6]);
        $('#tabla').val(desgloseUrl[5]);
        $('#confirmacion').modal({backdrop: 'static', keyboard: false})
            .one('click', '#borrar', function () {
                location.href = url;
            });
    });


    /*************************************************************************/
    /*                EVENTOS RELACIONADOS CON PERFIL DE USUARIO             */
    /*                                                                       */
    /*            ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------       */
    /*************************************************************************/

    /*
    Evento click que muestra en el mapa la posición guardada en latitud/longitud
     */
    $('#mapa').click(function(){
        var latitud = $('#latitud').val();
        var longitud = $('#longitud').val();
        //Añadimos 17z, que es la proximidad para poder er nombres de calles circundantes,
        //pero no demasiado cercana como para no distinguir la zona de la ciudad en la que estamos
        var url = 'https://www.google.es/maps/@' + latitud + ',' + longitud + ',17z';
        if (validar(latitud, longitud)){
            window.open(url, '_blank');
        }else{
            mostrarError('Las coordenadas no son válidas.');
        }
    });
    /*
    Geolocalización con API geolocation
     https://developers.google.com/maps/documentation/geocoding/intro?hl=es#StatusCodes
     */
    $('#localizacion').blur(function(){
        var direccion = $(this).val();
        var array = direccion.split(' ');
        direccion = '';
        for (var palabra in array) {
            direccion = direccion + array[palabra];
            if (palabra != array.length - 1){
                direccion = direccion + '+';
            }
        }
        //Quitamos el check de geolocalización, ya que si estábamos geolocalizados, al meter una dirección
        //quedaría anulado
        $('#geolocalizacion').prop('checked', false);
        llamarApi('https://maps.googleapis.com/maps/api/geocode/json?address=' +
            direccion + '&key=' + apiKey);
    });

    /*
    Geolocalización automática mediante dato procedente del navegador
     */

    $('#geolocalizacion').click(function(){
        if ($(this).prop('checked')){
            geolocalizar();
        }else{
            limpiar();
        }
    });


    /*************************************************************************/
    /*             EVENTOS RELACIONADOS CON PANTALLA BÚSQUEDA                */
    /*                                                                       */
    /*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
    /*************************************************************************/
    //initMap(); //Si dejamos esta línea activa, la geolocalización de Perfil da errores y no funciona
    //Se decide separa este script del de la pantalla de búsquedas, ya que los scripts de las apis de Google
    //son diferentes y en muchos casos, las declaraciones, incompatibles.

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
        var peticionDistancia = { origin: origen, destination: destino, travelMode: google.maps.TravelMode.WALKING};
        distancia.route(peticionDistancia, function(results, status){
            if (status == google.maps.DirectionsStatus.OK){
                //Añadimos in marcador en el mapa para esta localización
                var latitud = results.routes[0].legs[0].end_location.lat;
                var longitud = results.routes[0].legs[0].end_location.lng;
                var ubicacion = new google.maps.LatLng(latitud,longitud);

                var marker = new google.maps.Marker({
                    position: ubicacion,
                    title: nombreUsuario
                });
                marker.setMap(map);
                //Añadimos la distancia a la tabla
                $('#' + usuarioDestino).text(results.routes[0].legs[0].distance.text);

            }
        });
    });

    $('#verMapa').click(function(){
        $('#mapaBusquedas').removeClass('hidden');
    })

});

/*************************************************************************/
/*             FUNCIONES  RELACIONADAS CON PERFIL DE USUARIO             */
/*                                                                       */
/*         ---------ESPECÍFICOS DE GEOLOCALIZACIÓN-------------          */
/*************************************************************************/
/**
 * Función geolocalizar() que obtiene y gestiona el posicionamiento disponible
 * según el navegador cliente.
 *
 * Se realizará la llamada a la Api de Google y se volcará el resultado en los
 * contenedores previstos en el formulario del usuario.
 */
function geolocalizar(){
    //http://stackoverflow.com/questions/3397585/navigator-geolocation-getcurrentposition-sometimes-works-sometimes-doesnt
    resultado = navigator.geolocation.getCurrentPosition(obtenerPosicion);
}
function obtenerPosicion(posicion){
    var latitud = posicion.coords.latitude;
    var longitud = posicion.coords.longitude;
    if (validar(latitud, longitud)){
        llamarApi('https://maps.googleapis.com/maps/api/geocode/json?latlng='
            + latitud + ','
            + longitud + '&key=' + apiKey);
    }
}

/**
 * Función llamarApi(url) que gestiona la localización en la Api de Google correspondiente
 * mediante la url para la obtener los datos relacionados con la posición deseada.
 *
 * @param url
 * @param ruta boolean indica si la url corresponde a una ruta (2 localizaciones) o no.
 */
function llamarApi(url){
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'text',
        success: function (resultado) {
                mostrar(eval('(' + resultado + ')'));
        },
        error: function (resultado) {
            //En caso de error, derivamos la visualización del mensaje a
            //la función asociada.
            mostrarError(resultado);
        }
    });
}

/**
 * Función mostrar(coordenadas) que recibe el archivo json obtenido de la Api de
 * geolocalización de Google, y muestra los resultados en los contenedores
 * previstos para ello que son #localización, #latitud y #longitud
 *
 * @param coordenadas
 */
function mostrar(coordenadas) {
    limpiar(); //Lo primero limpiamos los contenedores para eliminar información antigua.
    limpiarErrores();
    if (coordenadas.status == 'OK'){
        $('#localizacion').val(coordenadas.results[0].formatted_address);
        $('#latitud').val(coordenadas.results[0].geometry.location.lat);
        $('#longitud').val(coordenadas.results[0].geometry.location.lng);
        $('#checkMap').prop('checked', false);
    }
}

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
function limpiar() {
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

    var latitud = +$('#latitud').val();
    var longitud = +$('#longitud').val();
    map = new google.maps.Map(document.getElementById('mapaBusquedas'), {
        zoom: 17,
        center: {lat: latitud, lng: longitud}
    });

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
        }
    });
    marker.setMap(map);
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