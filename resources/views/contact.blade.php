@extends('app')

@section('content')

    <div id="contenido" class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1 class="panel-title">Formulario de Contacto</h1></div>
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
                                @if(isset($correo) && $correo)
                                    Se ha enviado un mensaje automático para el administrador del sitio.<br>
                                @else
                                    Se ha generado la petición, pero no se ha podido enviar un aviso al
                                    administrador del sitio.<br>
                                @endif
                            </div>
                        @elseif(isset($exito) && !$exito))
                            <div class="alert alert-danger">
                                <strong>¡Atención!</strong> La operación no se ha podido completar.<br><br>
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="/contacto">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="nombre_usuario" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label pull-left">Usuario:</label>
                                        <div class="col-md-8 col-ms-offset-0 col-sm-9 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="nombre_usuario" type="text" class="form-control" name="nombre_usuario" value="{{auth()->user()->nombre_usuario}}" disabled data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Este es el nombre de usuario que tienes en tu perfil del sitio">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email_respuesta" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label pull-left">Email:</label>
                                        <div class="col-md-8 col-ms-offset-0 col-sm-9 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="email_respuesta" type="email" class="form-control" name="email_respuesta" required value="@if(count($errors) > 0){{old('email_respuesta')}}@else{{auth()->user()->email}}@endif" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Este es el email que tienes en tu perfil del sitio. Puedes indicar otro para recibir respuesta a esta petición">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="asunto" class="col-md-4 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label pull-left">Asunto:</label>
                                        <div class="col-md-8 col-ms-offset-0 col-sm-9 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                            <input id="asunto" type="text" class="form-control" name="asunto" value="@if(count($errors) > 0){{old('asunto')}}@endif" maxlength="50" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Aquí puedes poner una frase corta con tu petición">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                        <dl>
                                            <dt>Recuerda:</dt>
                                            <dd>- Este mensaje sólo lo verá el administrador del sitio.</dd>
                                            <dd>- Puedes incluir peticiones de apertura de nuevos productos o cualquier otra cuestión de tu interés.</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><label for="mensaje" class="panel-title">Mensaje:</label></div>
                                        <div class="panel-body">
                                            <textarea id="mensaje" class="form-control" name="mensaje" required maxlength="255" placeholder="Describe tu petición" rows="7" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Háblanos de tu petición en un máximo de 255 caracteres" autofocus>@if(count($errors) > 0){{old('mensaje')}}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2 col-sm-offset-10 col-sm-2 col-xs-offset-8 col-xs-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Pulsa aquí para enviar tu petición a Giftfinder">
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
