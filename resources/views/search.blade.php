@extends('maps') <!-- Para esta pantalla usamos otra cabecera, dado los problemas que conlleva usar el mismo script para maps y directions-->
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Búsqueda de Productos</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>¡Atención!</strong> Hay algún problema con tu entrada.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="/busqueda">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input id="locate_user" type="hidden" name="locate_user" value="{{ auth()->user()->localizacion }}">
                            <input id="latitud_user" type="hidden" name="latitud_user" value="{{ auth()->user()->latitud }}">
                            <input id="longitud_user" type="hidden" name="longitud_user" value="{{ auth()->user()->longitud }}">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-1 col-sm-offset-1 col-sm-1 col-xs-10 col-xs-offset-1">
                                        <label class="control-label">Elige</label>
                                    </div>
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-7 col-xs-offset-1">
                                        <select class="form-control" name="categoria">
                                            @foreach ($categoria as $item)
                                                <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-7 col-xs-offset-1">
                                        <select class="form-control" name="subcategoria">
                                            @foreach ($subcategoria as $item)
                                                <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-7 col-xs-offset-1">
                                        <select class="form-control" name="producto" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Elige el producto que deseas buscar" autofocus>
                                            <option>Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-3 col-xs-offset-9">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa aquí para ver el resultado de tu búsqueda">
                                                Ver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-11 col-sm-11 col-xs-12">
                                    <h4>Resultados de búsqueda para (ordenados por proximidad): {{$nombreProducto}}</h4>
                                </div>
                                <div class="col-md-1 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-3 col-xs-offset-9">
                                    <div class="form-group">
                                        <a href="#mapaBusquedas" type="button" id="verMapa" class="btn btn-success">
                                            Mapa
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <table id="resultados" class="table table-responsive table-striped">
                                <thead>
                                <td>Usuario</td>
                                <td>Email</td>
                                <td>Teléfono</td>
                                <td>Móvil</td>
                                <td>Whatsapp</td>
                                <td>Punto entrega</td>
                                <td>Distancia (kms)</td>
                                </thead>
                                @foreach($resultado as $item)
                                    <tr>
                                        <td id="usuario{{ $item->cod_usuario }}">{{ $item->nombre_usuario }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->telefono }} </td>
                                        <td>{{ $item->movil }}</td>
                                        <td>@if( $item->whatsapp ) Sí @else No @endif</td>
                                        <td class="localizacion{{ $item->cod_usuario }}">{{ $item->localizacion}}</td>
                                        <td id="{{ $item->cod_usuario }}" class="distancia"></td>
                                    </tr>
                                @endforeach
                            </table>
                            <div id="mapaBusquedas"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
