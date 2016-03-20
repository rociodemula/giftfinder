@extends('app')
{{-- Página de bienvenida al sistema. No es necesario estar logado para llegar aquí --}}
@section('content')
    <div id="contenido" class="container">
        <div class="content">
            @if (isset($baja) && $baja)
                <div class="alert alert-info">
                    <strong>¡Tu perfil ha sido borrado!</strong> Puedes volver a registrarte cuando quieras.<br>
                </div>
            @elseif(isset($baja) && !$baja)
                <div class="alert alert-info">
                    <strong>¡Tu perfil no se ha podido borrar!</strong> La operación no ha podido completarse.<br>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">¿Quiénes somos?</h1>
                </div>
                <div class="panel-body">
                    <p class="text-justify">Somos una comunidad interesada en regalar a otros esas cosas útiles que ya no necesitamos.</p>
                    <p class="text-justify">Necesitas registrarte o identificarte en nuestra web para ofrecer o solicitar los productos disponibles.
                        ¡Te costará solo un minuto! <a class="btn btn-xs btn-success" role="button" href="{{ url('/auth/register') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a formulario de registro">Altas</a></p>
                    <p class="text-justify">Si quieres compartir algo que te sobre y no lo encuentras entre las categorías/productos disponibles,
                        solicita un alta de nuevo producto al administrador del sitio.
                        <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a formulario de Contacto (debes estar registrado para esto)">Contacto</a></p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Nuestros productos</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        @foreach($producto as $item)
                        <div class="col-sm-3">
                            <ul class="list-group">
                                <li class="lead list-group-item">{{ $item->nombre_producto }}</li>
                                <li class="list-group-item"><img src="{{ $item->foto_producto }}" title="{{ $item->nombre_producto }}" alt="Imagen de {{ $item->nombre_producto }}" height="50" width="50"></li>
                                <li class="list-group-item">{{ $item->descripcion }}</li>
                                <li class="list-group-item"><a href="{{ $item->link_articulo }}" target="_blank" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Ver +info en Wikipedia (se abrirá en otra pestaña)">Más información</a></li>
                            </ul>
                        </div>
                        @endforeach
                        <div class="col-sm-3">
                            <ul class="list-group">
                                <li class="lead list-group-item">¡Encuentra donantes!</li>
                                <li class="list-group-item">Descubre personas dispuestas a regalar excedentes del producto de tu interés.</li>
                                <li class="list-group-item"><a class="btn btn-xs btn-success" role="button" href="{{ url('/busqueda') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a formulario de Busquedas (debes estar registrado para esto)">Búsqueda</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Si necesitas ayuda...</h1>
                </div>
                <div class="panel-body">
                    <p class="text-justify">Cualquier duda que tengas puedes transmitirla al administrador en
                        <a class="btn btn-xs btn-success" role="button" href="{{ url('/contacto') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a formulario de Contacto (debes estar registrado para esto)">Contacto</a> pero asegúrate
                        de consultar antes la <a class="btn btn-xs btn-success" role="button" href="{{ url('/ayuda') }}" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Ir a página de Ayuda">Ayuda</a></p>
                </div>
            </div>
        </div><br/><br/>
    </div>
@stop
