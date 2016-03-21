@extends('app')

@section('content')

    <div id="contenido" class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1 class="panel-title">Panel de Administración de la Base de datos</h1></div>
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
                        @elseif(isset($exito) && !$exito)
                        <div class="alert alert-danger">
                            <strong>¡Atención!</strong> La operación no se ha completado correctamente.<br>
                        </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="/cpanel">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-10">
                                        <label class="control-label" for="tablaM">Elige la tabla a modificar</label>
                                    </div>
                                    <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-offset-1 col-xs-8">
                                        <select id="tablaM" class="form-control" name="tabla" @if ($tabla == '') autofocus @endif data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Elige la tabla a modificar.">
                                            <option>Tabla</option>
                                            @foreach ($tablas as $item)
                                                <option>@if($item->$ddbb == old('tabla'))selected @endif{{$item->$ddbb}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-1 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-offset-9 col-xs-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">
                                                Ver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h4>Contenido de la tabla: {{ $tabla }} @if ($tabla != '' && $tabla != 'migrations' && $tabla != 'password_resets') <a href="{{URL::to('/cpanel/nuevo/'.$tabla)}}" class="btn btn-success btn-xs" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Añadir registro"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>@endif</h4>
                                </div>
                            </div>
                            <table class="table table-responsive table-striped">
                                    <thead>
                                    <td>Acciones</td>
                                    @if ($resultados != null)
                                        @foreach($campos as $campo)
                                            <td>{{ $campo }}</td>
                                        @endforeach
                                    @endif
                                    </thead>
                                    @if ($resultados != null)
                                        <tr @if (!$nuevo ) class="hidden" @endif>
                                            <form method="POST" action="{{'/cpanel/alta/'.$tabla}}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="tabla" value="{{$tabla}}"/>
                                                <td>
                                                    <button type="submit" class="btn btn-warning btn-xs" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Grabar"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                </td>
                                                @foreach($campos as $index => $campo)
                                                    <td><input name="{{$campo}}" class="form-control" value="@if(count($errors) > 0){{ old($campo) }}@endif"@if ($index == 0) readonly @elseif($index == 1) autofocus @endif/></td>
                                                @endforeach
                                            </form>
                                        </tr>
                                        @foreach($resultados as $registro)
                                            <tr @if ($editar && ($registro->$campos[0] == $id)) class="hidden" @endif>
                                                <td>
                                                    @if ($tabla != 'migrations' && $tabla != 'password_resets')
                                                        <a href="{{URL::to('/cpanel/editar/'.$tabla.'/'.$registro->$campos[0])}}" class="btn btn-success btn-xs" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                        <a href="{{URL::to('/cpanel/borrar/'.$tabla.'/'.$registro->$campos[0])}}" class="eliminar btn btn-danger btn-xs" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Borrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                    @endif
                                                </td>
                                                @foreach($campos as $campo)
                                                        <td>{{ $registro->$campo }}</td>
                                                @endforeach
                                            </tr>

                                            <tr @if (!$editar || ($registro->$campos[0] != $id)) class="hidden" @endif>
                                                <form method="POST" action="/cpanel/grabar">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="tabla" value="{{$tabla}}"/>
                                                    <input type="hidden" name="id" value="{{$registro->$campos[0]}}"/>
                                                    <td>
                                                        @if ($tabla != 'migrations' && $tabla != 'password_resets')
                                                            <button type="submit" class="btn btn-warning btn-xs" data-toogle="tooltip" rel="jslicense" data-placement="right" title="Grabar"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                        @endif
                                                    </td>
                                                    @foreach($campos as $index => $campo)
                                                        <td><input name="{{$campo}}" class="form-control" value="@if(count($errors) > 0){{ old($campo) }}@else{{ $registro->$campo }}@endif" @if ($index == 0) readonly @elseif($index == 1) autofocus @endif/>@if ($campo == 'nombre_usuario' || $campo == 'password' || $campo == 'email')<input name="{{$campo}}_old" value="{{ $registro->$campo }}" type="hidden"/>@endif</td>
                                                    @endforeach
                                                </form>
                                            </tr>
                                        @endforeach
                                    @endif
                            </table>
                            <div id="confirmacion" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Volver"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">¡Atención!</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Estás a punto de eliminar el registro:</p>
                                            <div class="row">
                                                <label class="control-label col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-11 col-xs-offset-1" for="borraRegistro">Código del registro a borrar: </label><input class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2" type="text" id="borraRegistro" name="borraRegistro" value=""readonly />
                                            </div>
                                            <div class="row">
                                                <label class="control-label col-md-5 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-11 col-xs-offset-1" for="tabla">Tabla en la que se encuentra: </label><input class="col-md-3 col-md-offset-0 col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2"  id="tabla" type="text" name="tabla" value="" readonly/>
                                            </div><br/>
                                            <p>En caso de se trate de un dato del que dependan otros, se producirá un borrado en cascada.</p>
                                            <p>Por ejemplo, si borras una categoría, estarás borrando las subcategorías y productos que comprende,
                                            si borras un usuario, estarás borrando las peticiones que ese usuario ha realizado.</p>
                                            <p>¿Estás completamente seguro de querer completar el borrado?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
                                            <button id="borrar" type="button" class="btn btn-danger">Si, eliminar este registro</button>
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
