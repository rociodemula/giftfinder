@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Perfil de Usuario</div>
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
                        @elseif(isset($exito) && $exito)
                            <div class="alert alert-success">
                                <strong>¡Hecho!</strong> La operación se ha realizado con éxito.<br>
                            </div>
                        @elseif(isset($exito) && !$exito))
                            <div class="alert alert-danger">
                                <strong>¡Atención!</strong> La operación no se ha podido completar.<br><br>
                            </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="/perfil">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Usuario</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre_usuario" value="@if(count($errors) > 0){{old('nombre_usuario')}}@else{{$usuario->nombre_usuario}}@endif">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Contraseña</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="clave">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Verificación </label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Localización </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="localizacion" value="@if(count($errors) > 0){{old('localizacion')}}@else{{$usuario->localizacion}}@endif">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!--TODO tanto latitud como longitud son obligatorios. Se pueden generar con gmaps a partir de la localización-->
                                        <!--TODO generar latitud y longitud a partir de localización con gmaps https://developers.google.com/maps/documentation/javascript/geocoding?hl=es-->
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="col-md-offset-4 col-md-3 control-label">Latitud</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="latitud" value="@if(count($errors) > 0){{old('latitud')}}@else{{$usuario->latitud}}@endif">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Longitud</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="longitud" value="@if(count($errors) > 0){{old('longitud')}}@else{{$usuario->longitud}}@endif">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-7">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Contacto:</div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">E-Mail</label>
                                                        <div class="col-md-9">
                                                            <input type="email" class="form-control" name="email" value="@if(count($errors) > 0){{old('email')}}@else{{$usuario->email}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Teléfono</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="telefono" value="@if(count($errors) > 0){{old('telefono')}}@else{{$usuario->telefono}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Móvil</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="movil" value="@if(count($errors) > 0){{old('movil')}}@else{{$usuario->movil}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <!--TODO este campo solo se podra marcar si se ha rellenado el campo móvil con un tlf movil-->
                                                            <input type="checkbox" class="form-control" name="whatsapp" @if($usuario->whatsapp == 1)checked @endif>
                                                        </div>
                                                        <label class="col-md-4"><img src="/img/whatsapp.png"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-1">
                                        <label class="control-label">Ofrezco</label>
                                    </div>
                                    @foreach ($compartido as $itemCompartido)
                                        <div class="col-md-3 {{$itemCompartido->codigo}}">
                                            <select class="form-control" name="categoria">
                                                @foreach ($categoria as $item)
                                                    <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 {{$itemCompartido->codigo}}">
                                            <select class="form-control" name="subcategoria">
                                                @foreach ($subcategoria as $item)
                                                    <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 {{$itemCompartido->codigo}}">

                                            <select class="form-control" name="productoCompartido[{{$itemCompartido->codigo}}]" id="productoCompartido{{$itemCompartido->codigo}}">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->cod_producto == $itemCompartido->producto) selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 {{$itemCompartido->codigo}}">
                                            <a class="btn btn-danger btn-sm borrarProducto" title="Dejar de compartir este producto" id="{{$itemCompartido->codigo}}">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-offset-1 col-md-1 {{$itemCompartido->codigo}}">
                                            <label class="control-label">y...</label>
                                        </div>
                                    @endforeach
                                    <div class="col-md-3 penultima">
                                        <select class="form-control" name="categoria">
                                            @foreach ($categoria as $item)
                                                <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 penultima">
                                        <select class="form-control" name="subcategoria">
                                            @foreach ($subcategoria as $item)
                                                <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 penultima">
                                        <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]">
                                            <option value="Producto">Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="nuevaLinea" class="hidden">
                                        <div class="col-md-1 penultima">
                                            <a class="btn btn-danger btn-sm borrarProducto" title="Dejar de compartir este producto" id="">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-offset-1 col-md-1 penultima">
                                            <label class="control-label">y...</label>
                                        </div>
                                        <div class="col-md-3 ultima">
                                            <select class="form-control" name="categoria">
                                                @foreach ($categoria as $item)
                                                    <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 ultima">
                                            <select class="form-control" name="subcategoria">
                                                @foreach ($subcategoria as $item)
                                                    <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 ultima">
                                            <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="fin" class="col-md-1">
                                        <a id="mas" class="btn btn-success btn-sm hidden" title="Compartir más productos">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                    <!--TODO accionar botón + para que añada otra linea con jQuery-->
                                    <!--TODO relacionar combos con jQuery para seleccionar categorías, subcategorias y productos enlazados-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="checkbox" class="form-control" name="geolocalizacion" @if($usuario->geolocalizacion == 1)checked @endif>
                                        </div>
                                        <label class="col-md-10">Activar geolocalización</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="checkbox" class="form-control" name="eliminar">
                                        </div>
                                        <label class="col-md-10">Eliminar mi perfil de usuario del sistema</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">
                                            Enviar
                                        </button>
                                    </div>

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
