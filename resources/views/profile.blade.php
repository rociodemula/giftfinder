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
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="/perfil">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Usuario</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre_usuario" value="@if(count($errors) > 0){{old('nombre_usuario')}}@else{{auth()->user()->nombre_usuario}}@endif">
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
                                            <input type="text" class="form-control" name="localizacion" value="@if(count($errors) > 0){{old('localizacion')}}@else{{auth()->user()->localizacion}}@endif">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!--TODO tanto latitud como longitud son obligatorios. Se pueden generar con gmaps a partir de la localización-->
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label class="col-md-offset-4 col-md-3 control-label">Latitud</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="latitud" value="@if(count($errors) > 0){{old('latitud')}}@else{{auth()->user()->latitud}}@endif">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Longitud</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" name="longitud" value="@if(count($errors) > 0){{old('longitud')}}@else{{auth()->user()->longitud}}@endif">
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
                                                            <input type="email" class="form-control" name="email" value="@if(count($errors) > 0){{old('email')}}@else{{auth()->user()->email}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Teléfono</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="telefono" value="@if(count($errors) > 0){{old('telefono')}}@else{{auth()->user()->telefono}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Móvil</label>
                                                        <div class="col-md-9">
                                                            <input type="number" class="form-control" name="movil" value="@if(count($errors) > 0){{old('movil')}}@else{{auth()->user()->movil}}@endif">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            <!--TODO este campo solo se podra marcar si se ha rellenado el campo móvil con un tlf movil-->
                                                            <input type="checkbox" class="form-control" name="whatsapp" @if(auth()->user()->whatsapp == 1)checked @endif>
                                                        </div>
                                                        <label class="col-md-4"><img src="/img/whatsapp.png"></label>
                                                    </div>
                                                </div>
                                                <!--TODO incluir en formulario que haya que especificar al menos un modo de contacto-->
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
                                    <div class="col-md-3">
                                        <select class="form-control" name="categoria">
                                            <option>Categoría</option>
                                            @foreach ($categoria as $item)
                                                <option @if($item->nombre_categoria == old('categoria'))selected @endif>{{ $item->nombre_categoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="subcategoria">
                                            <option>Subcategoría</option>
                                            @foreach ($subcategoria as $item)
                                                <option @if($item->nombre_subcategoria == old('subcategoria'))selected @endif>{{ $item->nombre_subcategoria }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="producto">
                                            <option>Producto</option>
                                            @foreach ($producto as $item)
                                                <option @if($item->nombre_producto == old('producto'))selected @endif>{{ $item->nombre_producto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--TODO incluir botón + que añada más artículos para compartir-->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <input type="checkbox" class="form-control" name="geolocalizacion" @if(auth()->user()->geolocalizacion == 1)checked @endif>
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
