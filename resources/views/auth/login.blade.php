@extends('app')

@section('content')
    <div id="contenido" class="container-fluid">
        <div class="row">

            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1 class="panel-title">Identifícate</h1></div>
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

                        <form class="form-horizontal" method="POST" action="/auth/login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="nombre_usuario" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-3 col-xs-offset-1 control-label">Usuario</label>
                                <div class="col-md-6 col-sm-6 col-xs-7">
                                    <input id="nombre_usuario" type="text" class="form-control" name="nombre_usuario" value="{{ old('nombre_usuario') }}" autofocus data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Teclea el nombre de usuario con el que te registraste en el sitio.">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-3 col-xs-offset-1 control-label">Clave</label>
                                <div class="col-md-6 col-sm-6 col-xs-7">
                                    <input id="password" type="password" class="form-control" name="password" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Contraseña que usaste al registrarte en el sitio.">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-6 col-xs-offset-4">
                                    <div class="checkbox">
                                        <label for="remember">
                                            <input id="remember" type="checkbox" name="remember" data-toogle="tooltip" rel="jslicense" data-placement="left" title="Pulsa aquí si quieres que tu navegador recuerde tus datos de usuario y clave"> Recuerdame
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4 col-sm-8 col-sm-offset-4 col-xs-11 col-xs-offset-1">
                                    <button type="submit" class="btn btn-success" style="margin-right: 15px;" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Acceder con tu usuario al sitio.">
                                        Identifícate
                                    </button>

                                    <a href="/password/email" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Si has olvidado tu clave, podemos enviarte un enlace a tu correo para que la recuperes.">¿Has olvidado tu clave?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
