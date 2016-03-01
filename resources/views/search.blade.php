@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-1">
                                        <label class="control-label">Elige</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="categoria">
                                            @foreach ($categoria as $item)
                                                <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="subcategoria">
                                            @foreach ($subcategoria as $item)
                                                <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="producto" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Elige el producto que deseas buscar">
                                            <option>Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa aquí para ver el resultado de tu búsqueda">
                                                Ver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <h4>Resultados de búsqueda (ordenados por proximidad):</h4>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <!--TODO opción para ver localización en el mapa, ver https://styde.net/integrar-google-maps-en-laravel-5-con-phpgmaps/-->
                                        <button type="button" id="mapa" class="btn btn-success">
                                            Ver resultados en mapa
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <table class="table table-responsive table-striped">
                                <thead>
                                <td>Usuario</td>
                                <td>Email</td>
                                <td>Teléfono</td>
                                <td>Móvil</td>
                                <td>Whatsapp</td>
                                <td>Punto entrega</td>
                                </thead>
                                @foreach($resultado as $item)
                                    <tr>
                                        <td>{{ $item->nombre_usuario }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->telefono }} </td>
                                        <td>{{ $item->movil }}</td>
                                        <td>@if( $item->whatsapp ) Sí @else No @endif</td>
                                        <td>{{ $item->localizacion}}</td>
                                    </tr>
                                @endforeach



                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
