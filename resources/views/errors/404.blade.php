@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>¡Lo sentimos!</strong> La página que buscas no existe.</h3>
                    </div>
                    <div class="panel-body">
                        <dl>
                            <dt>Es posible que:</dt>
                            <dd>- La url no sea la correcta o que no esté operativa de forma temporal.</dd>
                            <dd>- Puedes volver a la página principal pulsando inicio en el menú y volver a intentarlo.</dd>
                            <dd>- Si el problema persiste, no dudes en ponerte en contacto con los administradores del
                                sitio a través de nuestro formulario de <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}">Contacto</a>.</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
