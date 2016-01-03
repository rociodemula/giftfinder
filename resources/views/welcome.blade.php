@extends('app')
{{-- Página de bienvenida al sistema. No es necesario estar logado para llegar aquí --}}
@section('content')
    <div class="container">
        <div class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">¿Quiénes somos?</h3>
                </div>
                <div class="panel-body">
                    <p class="text-justify">Somos una comunidad interesada en regalar a otros cosas útiles que ya no necesitamos.</p>
                    <p class="text-justify">Necesitas registrarte o identificarte en nuestra web para ofrecer o solicitar los productos disponibles.
                        ¡Te costará solo un minuto! <a class="btn btn-xs btn-success" role="button" href="{{ url('/auth/register') }}">Altas</a></p>
                    <p class="text-justify">Si quieres compartir algo que te sobre y no lo encuentras entre las categorías/productos disponibles,
                        solicita un alta de nuevo producto al administrador del sitio.
                        <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}">Contacto</a></p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Nuestros productos</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($producto as $item)
                        <div class="col-sm-3">
                            <ul class="list-group">
                                <li class="lead list-group-item">{{ $item->nombre_producto }}</li>
                                <li class="list-group-item"><img src="{{ $item->foto_producto }}"></li>
                                <li class="list-group-item">{{ $item->descripcion }}</li>
                                <li class="list-group-item"><a href="{{ $item->link_articulo }}">Más información</a></li>
                            </ul>
                        </div>
                        @endforeach
                        <div class="col-sm-3">
                            <ul class="list-group">
                                <li class="lead list-group-item">¡Encuentra donantes!</li>
                                <li class="list-group-item"><a class="btn btn-xs btn-success" role="button" href="{{ url('/busqueda') }}">Búsqueda</a></p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Si necesitas ayuda...</h3>
                </div>
                <div class="panel-body">
                    <p class="text-justify">Cualquier duda que tengas puedes transmitirla al administrador en
                        <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}">Contacto</a> pero asegúrate
                        de consultar antes la <a class="btn btn-xs btn-success" role="button" href="{{ url('/ayuda') }}">Ayuda</a></p>
                </div>
            </div>
        </div><br/><br/>
    </div>
@stop
