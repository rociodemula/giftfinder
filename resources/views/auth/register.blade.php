@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Alta de Usuario</div>
                    <div class="panel-body">
                    <!-- Bloque de volcado de errores-->
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

                        <form class="form-horizontal" role="form" method="POST" action="/auth/register">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Usuario</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre_usuario" maxlength="30" required value="{{ old('nombre_usuario') }}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Este será tu usuario de acceso a la plataforma">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Contraseña</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password" pattern=".{6,}" required data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Debe tener mínimo 6 caracteres">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Verificación </label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password_confirmation" pattern=".{6,}" required data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Vuelve a teclear la contraseña">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Localización </label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="localizacion" maxlength="60" value="{{ old('localizacion') }}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Sitio que prefieres para las entregas/recogidas">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="col-md-offset-4 col-md-3 control-label">Latitud</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="latitud" required value="{{ old('latitud') }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Longitud</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="longitud" required value="{{ old('longitud') }}">
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
                                                            <input type="email" class="form-control" name="email" maxlength="80" required value="{{ old('email') }}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Tu email es necesario para registrarte, así podrás recuperar tu contraseña si la olvidas">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Teléfono</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="telefono" value="{{ old('telefono') }}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes compartir tu teléfono si quieres">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Móvil</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="movil" value="{{ old('movil') }}" data-toogle="tooltip" rel="txtTooltip" data-placement="bottom" title="Puedes compartir tu móvil si quieres">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <input type="checkbox" class="form-control" name="whatsapp" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Si quieres que te contacten por whatsapp marca esta opción">
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
                                            <input type="checkbox" class="form-control" name="geolocalizacion" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Si quieres activar la geolocalización de tu dispositivo, marca esta opción">
                                        </div>
                                        <label class="col-md-10">Activar geolocalización</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="checkbox" class="form-control" name="acepto" required data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Es necesario aceptar las condiciones del sitio para continuar">
                                        </div>
                                        <label class="col-md-10">He leído y acepto las condiciones de uso</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Pulsa aquí para grabar tu perfil en Giftfinder">
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
