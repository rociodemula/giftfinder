/**
 * Created by rocio on 27/02/16.
 */
var index = 0; //variable estática para controlar los indez de los productos añadidos dinámicamente
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
    Inizializando las tooltips de bootstrap para indicaciones sobre algunos campos del formulario.
     */
    $('input[rel="txtTooltip"]').tooltip();
    $('select[rel="txtTooltip"]').tooltip();
    $('a[rel="txtTooltip"]').tooltip();
    $('button[rel="txtTooltip"]').tooltip();
    $('textarea[rel="txtTooltip"]').tooltip();
});
