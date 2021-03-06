@extends('app')

@section('content')

    <div id="contenido" class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1 class="panel-title">Perfil de Usuario</h1></div>
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
                        <form id="perfil" class="form-horizontal" method="POST" action="/perfil">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="nombre_usuario" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label">Usuario</label>
                                        <div class="col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="nombre_usuario" type="text" class="form-control" name="nombre_usuario" maxlength="30" required value="@if(count($errors) > 0){{old('nombre_usuario')}}@else{{$usuario->nombre_usuario}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Puedes cambiar el nombre de usuario con el que accedes al sitio" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label">Contraseña</label>
                                        <div class="col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="password" type="password" class="form-control" name="password" pattern=".{6,}" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Si quieres cambiar tu contraseña, recuerda que debe tener mínimo 6 caracteres">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label">Verificación </label>
                                        <div class="col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" pattern=".{6,}" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Vuelve a teclear la contraseña">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="localizacion" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label">Localización </label>
                                        <div class="col-md-7 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="localizacion" type="text" class="form-control" name="localizacion" maxlength="100" required value="@if(count($errors) > 0){{old('localizacion')}}@else{{$usuario->localizacion}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Recuerda que esta localización es el sitio donde prefieres hacer las entregas/recogidas">
                                        </div>
                                    </div>

                                    <div class="row recuadro-gris">
                                        <div class="form-group col-md-5 col-sm-5 col-xs-12">
                                            <label for="latitud" class="col-md-6 col-sm-5 col-xs-5 control-label">Latitud</label>
                                            <div class="col-md-6 col-sm-7 col-xs-7">
                                                <input id="latitud" type="text" class="form-control" name="latitud" readonly required value="@if(count($errors) > 0){{old('latitud')}}@else{{$usuario->latitud}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="La latitud se generará automáticamente al poner la localización">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5 col-sm-5 col-xs-12">
                                            <label for="longitud" class="col-md-6 col-sm-5 col-xs-5 control-label">Longitud</label>
                                            <div class="col-md-6 col-sm-7 col-xs-7">
                                                <input id="longitud" type="text" class="form-control" name="longitud" readonly required value="@if(count($errors) > 0){{old('longitud')}}@else{{$usuario->longitud}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="La longitud se generará automáticamente al poner la localización">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                            <label for="checkMap" class="col-md-8 col-md-offset-0 col-sm-7 col-sm-offset-0 col-xs-2 col-xs-offset-5">
                                                <a id="mapa" class="btn btn-warning btn-sm pull-right"  href="#" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Pulsa para comprobar la localización en el mapa"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></a>
                                            </label>
                                            <div class="col-md-1 col-ms-offset-0 col-sm-offset-0 col-sm-1 col-xs-offset-1 col-xs-2">
                                                <input id="checkMap" type="checkbox" class="pull-right" name="mapa" checked   data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Marca esta casilla si la dirección está donde esperas en el mapa">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-5 col-md-offset-0 col-sm-10 col-sm-offset-1 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Contacto:</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="email" class="col-md-3 col-sm-3 col-xs-12 control-label">E-Mail</label>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                   <input id="email" type="email" class="form-control" name="email" maxlength="80" required value="@if(count($errors) > 0){{old('email')}}@else{{$usuario->email}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Puedes cambiar tu email cuando quieras, pero necesitamos alguno para que puedas recuperar tu contraseña si la olvidas">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono" class="col-md-3 col-sm-3 col-xs-10 control-label">Teléfono</label>
                                                <div class="col-md-6 col-sm-6 col-xs-9">
                                                    <input id="telefono" type="number" class="form-control" name="telefono" min="800000000" max="999999999" value="@if(count($errors) > 0){{old('telefono')}}@else{{$usuario->telefono}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Puedes compartir tu teléfono si quieres">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="movil" class="col-md-3 col-sm-3 col-xs-10 control-label">Móvil</label>
                                                <div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-8">
                                                    <input id="movil" type="number" class="form-control" name="movil" min="500000000" max="799999999" value="@if(count($errors) > 0){{old('movil')}}@else{{$usuario->movil}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Puedes compartir tu móvil si quieres">
                                                </div>
                                                <div class="col-md-1 col-sm-1 col-xs-1">
                                                    <input id="whatsapp" type="checkbox" class="pull-right" name="whatsapp" @if($usuario->whatsapp == 1)checked @endif data-toogle="tooltip" rel="jslicense" data-placement="right" title="Si quieres que te contacten por whatsapp marca esta opción">
                                                </div>
                                                <label for="whatsapp" id="labelWhatsapp" class="col-md-2 col-sm-2 col-xs-1"><img src="/img/whatsapp.png" alt="logo de whatsapp"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-1 col-sm-1 col-sm-offset-1 col-xs-9 col-xs-offset-1">
                                        <label for="categoria" class="control-label">Ofrezco</label>
                                    </div>
                                    @foreach ($compartido as $itemCompartido)
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1  {{$itemCompartido->codigo}}">
                                            <select id="categoria" class="form-control" name="categoria">
                                                @foreach ($categoria as $item)
                                                    <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1 {{$itemCompartido->codigo}}">
                                            <select class="form-control" name="subcategoria">
                                                @foreach ($subcategoria as $item)
                                                    <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1 {{$itemCompartido->codigo}}">

                                            <select class="form-control" name="productoCompartido[{{$itemCompartido->codigo}}]" id="productoCompartido{{$itemCompartido->codigo}}" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Actualmente compartes este producto">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->cod_producto == $itemCompartido->producto) selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-2  {{$itemCompartido->codigo}}">
                                            <a class="btn btn-danger btn-sm borrarProducto" id="{{$itemCompartido->codigo}}" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Pulsa aquí para dejar de compartir este producto">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-offset-1 col-md-1 col-sm-offset-1 col-sm-1 col-xs-9 col-xs-offset-1 {{$itemCompartido->codigo}}">
                                            <label for="productoNuevo" class="control-label">y...</label>
                                        </div>
                                    @endforeach
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1 penultima">
                                        <select id="categoria" class="form-control" name="categoria">
                                            @foreach ($categoria as $item)
                                                <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1  penultima">
                                        <select class="form-control" name="subcategoria">
                                            @foreach ($subcategoria as $item)
                                                <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1 penultima">
                                        <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Si ofreces algún producto, seleccionalo aquí">
                                            <option value="Producto">Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="nuevaLinea" class="hidden">
                                        <div class="col-md-1 col-sm-1 col-xs-2 penultima">
                                            <a class="btn btn-danger btn-sm borrarProducto" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Pulsa aquí para dejar de compartir este producto">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                        <div class="col-md-offset-1 col-md-1 col-sm-offset-1 col-sm-1 col-xs-9 col-xs-offset-1 penultima">
                                            <label for="categoria" class="control-label">y...</label>
                                        </div>
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1  ultima">
                                            <select id="productoNuevo" class="form-control" name="categoria">
                                                @foreach ($categoria as $item)
                                                    <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1  ultima">
                                            <select class="form-control" name="subcategoria">
                                                @foreach ($subcategoria as $item)
                                                    <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-9 col-xs-offset-1  ultima">
                                            <select id="productoNuevo" class="form-control productoNuevo" name="producto[0]" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Si ofreces algún producto, seleccionalo aquí">
                                                <option value="Producto">Producto</option>
                                                @foreach ($producto as $item)
                                                    <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div id="fin" class="col-md-1 col-sm-1 col-xs-2">
                                        <a id="mas" class="btn btn-success btn-sm hidden" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Pulsa aquí para compartir otro producto">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <input id="geolocalizacion" type="checkbox" class="pull-right" name="geolocalizacion" @if($usuario->geolocalizacion == 1)checked @endif data-toogle="tooltip" rel="jslicense" data-placement="right" title="Si quieres activar la geolocalización de tu dispositivo, marca esta opción">
                                        </div>
                                        <label for="geolocalizacion" class="col-md-10 col-sm-10 col-xs-10">Activar geolocalización</label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <input id="eliminar" type="checkbox" class="pull-right" name="eliminar" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Pulsa esta opción si quieres borrar tu perfil de Giftfinder">
                                        </div>
                                        <label for="eliminar" class="col-md-10 col-sm-10 col-xs-10">Eliminar mi perfil de usuario del sistema</label>
                                    </div>
                                </div>
                                <div class="col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-0 col-xs-offset-4 col-xs-4">
                                    <div class="form-group">
                                        <button id="enviar" type="submit" class="btn btn-success" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Pulsa para enviar la petición de cambio de perfil">
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
                        </div>
                        <div id="confirmaPosicion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mensajeConfirmar">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" aria-label="Close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 id="mensajeConfirmar" class="modal-title">¡Localización no confirmada!</h4>

                                    </div>
                                    <div class="modal-body">
                                        <p>No has confirmado que la localización es correcta en el mapa.</p>
                                        <p>Es importante que tu sitio para las entregas sea el correcto. Comprúebalo y marca la casilla junto a latitud/longitud.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="errorGeolocalizacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mensajeConfirmar">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" aria-label="Close" data-dismiss="modal" type="button">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 id="mensajeInformar" class="modal-title">¡Geolocalización no detectada!</h4>

                                    </div>
                                    <div class="modal-body">
                                        <p>Necesitamos que des permiso para detectar tu posición.</p>
                                        <p>Este proceso varía según el navegador que uses, y es posible que no hayas
                                            realizado la autorización de forma correcta, o que tu navegador no disponga
                                            de esta opción.</p>
                                        <p>Recuerda que puedes indicar la dirección que te interese manualmente en 'Localización'
                                           y se detectará la latitud y longitud automáticamente.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
