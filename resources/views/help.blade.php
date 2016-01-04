@extends('app')

@section('content')

    <div class="container-fluid">
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
                            <dd>- Una vez registrado, cualqueir usuario puede darse de baja en el sistema marcando la
                                opción de 'Eliminar perfil del sistema' existente en el formulario de gestión de Perfil.</dd>
                            <dd>- Para cualquier duda adicional, siempre puedes consultar el manual de uso del sitio, o
                                descargar la documentación.</dd>
                        </dl>
                        <dl>
                            <dt>Manuales:</dt>
                            <dd>- Puedes visualizar los manuales en pdf de la aplicación, o bien descargarlos para
                                consultarlos más tarde pulsando <a href="http://giftfinder.demosdata.com/doc/">aquí</a>.</dd>
                            <!--TODO elaborar manual en pdf para el usuario. De momento este enlace apunta a la documentación del proyecto-->
                        </dl>
                        <dl>
                            <dt>Cookies:</dt>
                            <dd>- Las cookies son necesarias para la correcta gestión de login de los usuarios que acceden
                                al sitio. Para más información, consulta este
                                <a href="http://politicadecookies.com/index.php">enlace</a>.</dd>
                            <!--TODO revisar politica de cookies. Es necesario un popup nada más entrar en el sitio donde se acepte la política por parte del usuario-->
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
