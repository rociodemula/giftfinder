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
                        <form id="perfil" class="form-horizontal" role="form" method="POST" action="/perfil">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Usuario</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre_usuario" maxlength="30" required value="@if(count($errors) > 0){{old('nombre_usuario')}}@else{{$usuario->nombre_usuario}}@endif" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes cambiar el nombre de usuario con el que accedes al sitio">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Contraseña</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password" pattern=".{6,}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Si quieres cambiar tu contraseña, recuerda que debe tener mínimo 6 caracteres">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Verificación </label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password_confirmation" pattern=".{6,}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Vuelve a teclear la contraseña">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Localización </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="localizacion" maxlength="60" value="@if(count($errors) > 0){{old('localizacion')}}@else{{$usuario->localizacion}}@endif" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Recuerda que esta localización es el sitio donde prefieres hacer las entregas/recogidas">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!--TODO tanto latitud como longitud son obligatorios. Se pueden generar con gmaps a partir de la localización-->
                                        <!--TODO generar latitud y longitud a partir de localización con gmaps https://developers.google.com/maps/documentation/javascript/geocoding?hl=es-->
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="col-md-offset-4 col-md-3 control-label">Latitud</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="latitud" required value="@if(count($errors) > 0){{old('latitud')}}@else{{$usuario->latitud}}@endif">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Longitud</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="longitud" required value="@if(count($errors) > 0){{old('longitud')}}@else{{$usuario->longitud}}@endif">
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
                                                            <input type="email" class="form-control" name="email" maxlength="80" required value="@if(count($errors) > 0){{old('email')}}@else{{$usuario->email}}@endif" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes cambiar tu email cuando quieras, pero necesitamos alguno para que puedas recuperar tu contraseña si la olvidas">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Teléfono</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="telefono" value="@if(count($errors) > 0){{old('telefono')}}@else{{$usuario->telefono}}@endif" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes compartir tu teléfono si quieres">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Móvil</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="movil" value="@if(count($errors) > 0){{old('movil')}}@else{{$usuario->movil}}@endif" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes compartir tu móvil si quieres">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <!--TODO este campo solo se podra marcar si se ha rellenado el campo móvil con un tlf movil-->
                                                            <input type="checkbox" class="form-control" name="whatsapp" @if($usuario->whatsapp == 1)checked @endif data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Si quieres que te contacten por whatsapp marca esta opción">
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

                                            <select class="form-control" name="productoCompartido[{{$itemCompartido->codigo}}]" id="productoCompartido{{$itemCompartido->codigo}}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Actualmente compartes este producto">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->cod_producto == $itemCompartido->producto) selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 {{$itemCompartido->codigo}}">
                                            <a class="btn btn-danger btn-sm borrarProducto" id="{{$itemCompartido->codigo}}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa aquí para dejar de compartir este producto">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
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
                                        <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Si ofreces algún producto, seleccionalo aquí">
                                            <option value="Producto">Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="nuevaLinea" class="hidden">
                                        <div class="col-md-1 penultima">
                                            <a class="btn btn-danger btn-sm borrarProducto" id="" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa aquí para dejar de compartir este producto">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
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
                                            <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Si ofreces algún producto, seleccionalo aquí">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="fin" class="col-md-1">
                                        <a id="mas" class="btn btn-success btn-sm hidden" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa aquí para compartir otro producto">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="checkbox" class="form-control" name="geolocalizacion" @if($usuario->geolocalizacion == 1)checked @endif data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Si quieres activar la geolocalización de tu dispositivo, marca esta opción">
                                        </div>
                                        <label class="col-md-10">Activar geolocalización</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input id="eliminar" type="checkbox" class="form-control" name="eliminar" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Pulsa esta opción si quieres borrar tu perfil de Giftfinder">
                                        </div>
                                        <label class="col-md-10">Eliminar mi perfil de usuario del sistema</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button id="enviar" type="submit" class="btn btn-success" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Pulsa para enviar la petición de cambio de perfil">
                                            Enviar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div id="confirmacion" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Volver"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">¡Atención!</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Estás a punto de eliminar tu perfil del sitio. Perderás todo tu historial y productos compartidos y no tendrás acceso a la plataforma para seguir realizando búsquedas de artículos.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                                        <button id="borrar" type="button" class="btn btn-danger">Eliminar mi perfil de Giftfinder</button>
                                    </div>
                                </div>
                            </div>
                        </div><
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
