@extends('app')

@section('content')

    <div id="contenido" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <dl>
                            <dt>Ayuda:</dt>
                            <dd>- Puedes navegar libremente desde cualquier página gracias al menú superior de opciones.</dd>
                            <dd>- Recuerda que las opciones de Perfil, Búsqueda y Contacto están reservadas para
                                usuarios registrados.</dd>
                            <dd>- En el menú inferior, a pie de página, tienes algunas opciones referentes a la legalidad
                                del sitio, derechos de autor y esta ayuda.</dd>
                            <dd>- Una vez registrado, cualquier usuario puede darse de baja en el sistema marcando la
                                opción de 'Eliminar perfil del sistema' existente en el formulario de gestión de Perfil.</dd>
                            <dd>- En todas las pantallas de la aplicación existe ayuda para cada cada dato a rellenar. Dejando el
                                ratón sobre un elemento de la pantalla puedes ver ayuda adicional de cómo rellenar el dato y qué
                                debe contener.</dd>
                        </dl>
                        <dl>
                            <dt>Manuales técnicos:</dt>
                            <dd>- Puedes visualizar los manuales técnicos de la aplicación, o bien descargarlos para
                                consultarlos más tarde pulsando <a href="http://giftfinder.demosdata.com/doc/" target="_blank" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a documentación (se abrirá en otra pestaña)">aquí</a>.</dd>
                        </dl>
                        <dl>
                            <dt>Uso del sitio:</dt>
                            <dd>- Puedes acceder a las condiciones de uso del sitio <a href="{{ url('/condiciones') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a Condiciones de uso">aquí</a>.</dd>
                        </dl>
                        <dl>
                            <dt>Autor:</dt>
                            <dd>- Tienes más datos del copyright del sitio <a href="{{ url('/derechos') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a Derechos de autor">aquí</a>.</dd>
                        </dl>
                        <dl>
                            <dt>Cookies:</dt>
                            <dd>- Las cookies son necesarias para la correcta gestión de login de los usuarios que acceden
                                al sitio. Para más información, consulta este
                                <a href="http://politicadecookies.com/index.php" target="_blank" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a página Política de Cookies (se abrirá en otra pestaña)">enlace</a>.</dd>
                            <!--TODO revisar politica de cookies para la fase II de desarrollo. Es necesario un popup nada más entrar en el sitio donde se acepte la política por parte del usuario-->
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
