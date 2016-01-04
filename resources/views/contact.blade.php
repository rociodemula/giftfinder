@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Formulario de Contacto</div>
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
                        <form class="form-horizontal" role="form" method="POST" action="/contacto">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Usuario:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre_usuario" value="@if(count($errors) > 0){{old('nombre_usuario')}}@else{{auth()->user()->nombre_usuario}}@endif" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Email:</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="email_respuesta" value="@if(count($errors) > 0){{old('email')}}@else{{auth()->user()->email}}@endif">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label pull-left">Asunto:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="asunto">
                                        </div>
                                    </div>

                                    <div class="">
                                        <dl>
                                            <dt>Recuerda:</dt>
                                            <dd>- Este mensaje sólo lo verá el administrador del sitio.</dd>
                                            <dd>- Es importante que facilites tu email para recibir una respuesta.</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Mensaje:</div>
                                        <div class="panel-body">
                                            <textarea class="form-control" name="mensaje" placeholder="Describe tu petición" rows="7"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-md-offset-10 col-md-2">
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
