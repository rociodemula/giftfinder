/**
 * Created by rocio on 27/02/16.
 */
var index = 0; //variable estática para controlar los index de los productos añadidos dinámicamente
var apiKey = 'AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM';
$(function(){
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
    Inicializando las tooltips de bootstrap para indicaciones sobre algunos campos del formulario.
     */
    $('input[rel="txtTooltip"]').tooltip();
    $('select[rel="txtTooltip"]').tooltip();
    $('a[rel="txtTooltip"]').tooltip();
    $('button[rel="txtTooltip"]').tooltip();
    $('textarea[rel="txtTooltip"]').tooltip();

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
        llamarApi('https://maps.googleapis.com/maps/api/geocode/json?address=' + direccion + '&key=' + apiKey);
    });

    $('#geolocalizacion').click(function(){
        if ($(this).prop('checked')){
            geolocalizar();
        }else{
            limpiar();
        }
    });


});
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
            + longitud + '&key=' + apiKey );
    }
}

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

/*
 Validar latidud/longitud, según expresión regular
 http://stackoverflow.com/questions/22903756/using-regular-expression-to-validate-latitude-and-longitude-coordinates-then-dis
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
function limpiarErrores(){
    if ($('#contenedorErrores').length){
        $(this).html('');
    }
}