/**
 * Script jQuery para gestionar eventos y demás contenido dinámico de la aplicación en general.
 * Casi toda la funcionalidad es específica de la página de alta/perfil de usuario.
 *
 * Created by rocio on 27/02/16.
 */
var index = 0; //variable estática para controlar los index de los productos añadidos dinámicamente
var apiKey = 'AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM'; //La clave api obtenida de nuestra cuenta de google es necesaria.

//Utilidad duck-typing para localizar el navegador usado por el usuario, obtenida de:
//http://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser

// Opera 8.0+
var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
// Firefox 1.0+
var isFirefox = typeof InstallTrigger !== 'undefined';
// At least Safari 3+: "[object HTMLElementConstructor]"
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
// Internet Explorer 6-11
var isIE = /*@cc_on!@*/false || !!document.documentMode;
// Edge 20+
var isEdge = !isIE && !!window.StyleMedia;
// Chrome 1+
var isChrome = !!window.chrome && !!window.chrome.webstore;
// Blink engine detection
var isBlink = (isChrome || isOpera) && !!window.CSS;

$(function(){ //Una vez cargada la página declaramos los eventos.
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

    /*
    Visualiza el cuadro modal pidiendo cnfirmación en caso de que pulsemos el botón
    para borrar un registro.
    Alimentamos un formulario interno en el modal, que nos vale para mostrar los datos
    del registro que se quiere borrar.
     */
    $('.eliminar').click(function(e) {
        e.preventDefault();
        //Guardamos la url a la que tenemos que redirigir la página en caso de confirmación positiva:
        var url = $(this).attr('href');
        var desgloseUrl = url.split('/');
        //Con estos datos inyectamos valores al cuadro modal:
        $('#borraRegistro').val(desgloseUrl[6]);
        $('#tabla').val(desgloseUrl[5]);
        //Mostramos el modal, y en caso de confirmación, redirigimos el flujo a la url de borrado.
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
    //Usamos idea procedente de:
    //http://stackoverflow.com/questions/3397585/navigator-geolocation-getcurrentposition-sometimes-works-sometimes-doesnt
    resultado = navigator.geolocation.getCurrentPosition(obtenerPosicion, errorGeolocalizar, {timeout:10000});

}
/**
 * Función que geolocaliza una posición basandose en los datos diferentes a los facilitados por el navegador (p.e., IP)
 * Es posible utilizarla en navegadores que no dispongan de otra alternativa, pero es un sistema altamente inexacto.
 */
function geolocalizarIP(){
    llamarApi('https://maps.googleapis.com/maps/api/geocode/json?latlng='
        + geoplugin_latitude() + ','
        + geoplugin_longitude() + '&key=' + apiKey);
}
function errorGeolocalizar(){
    $('#errorGeolocalizacion').modal('show');
}
/**
 * Función obtenerPosicion() que obtiene la latitud y longitud del navegador, en combinación
 * con la función geolocalizar()
 *
 * @param posicion
 */
function obtenerPosicion(posicion){
    var latitud = posicion.coords.latitude;
    var longitud = posicion.coords.longitude;
    if (validar(latitud, longitud)){
        //Una vez que tenemos la latitud/longitud provenientes del navegador,
        //usamos la función llamarApi para obtener la dirección formateada y
        //mostrarla en el campo localización.
        llamarApi('https://maps.googleapis.com/maps/api/geocode/json?latlng='
            + latitud + ','
            + longitud + '&key=' + apiKey);
    }
}

/**
 * Función llamarApi(url) que gestiona la localización en la Api de Google correspondiente
 * mediante la url para la obtener los datos relacionados con la posición deseada.
 * Los vuelca en el campo localización medainte la función mostrar().
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
            //Si es exitosa la petición ajax, volcamos el resultado en los
            //diferentes campos del formulario relacionados:
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

