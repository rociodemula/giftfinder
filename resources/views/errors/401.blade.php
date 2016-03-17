@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>¡Lo sentimos!</strong> No estás autorizado a visitar esta página.</h3>
                    </div>
                    <div class="panel-body">
                        <dl>
                            <dt>Es posible que:</dt>
                            <dd>- No te hayas identificado correctamente.</dd>
                            <dd>- Tu perfil de usuario no tenga permisos suficientes para visitar esta parte de la aplicación.</dd>
                            <dd>- Si el problema persiste y piensas que se ha producido una confusión, no dudes en ponerte en contacto con los administradores del
                                sitio a través de nuestro formulario de <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}">Contacto</a>.</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
