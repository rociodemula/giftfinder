@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Panel de Administración de la Base de datos</div>
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
                            <strong>¡Atención!</strong> No se ha realizado ningún cambio.<br><br>
                        </div>
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="/cpanel">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3 col-sm-offset-1 col-sm-3 col-xs-offset-1 col-xs-10">
                                        <label class="control-label">Elige la tabla a modificar</label>
                                    </div>
                                    <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-offset-1 col-xs-8">
                                        <select class="form-control" name="tabla">
                                            <option>Tabla</option>
                                            @foreach ($tablas as $item)
                                                <option>@if($item->Tables_in_giftfinder == old('tabla'))selected @endif{{$item->Tables_in_giftfinder}}</option>
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
                                    <h4>Contenido de la tabla: {{ $tabla }} @if ($tabla != '' && $tabla != 'migrations' && $tabla != 'password_resets') <a href="{{URL::to('/cpanel/nuevo/'.$tabla)}}" class="btn btn-success btn-xs" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Añadir registro"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>@endif</h4>
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
                                                    <button type="submit" class="btn btn-warning btn-xs" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Grabar"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                </td>
                                                @foreach($campos as $index => $campo)
                                                    <td><input name="{{$campo}}" value="{{ old($campo) }}"@if ($index == 0) readonly @endif/></td>
                                                @endforeach
                                            </form>
                                        </tr>
                                        @foreach($resultados as $registro)
                                            <tr @if ($editar && ($registro->$campos[0] == $id)) class="hidden" @endif>
                                                <td>
                                                    @if ($tabla != 'migrations' && $tabla != 'password_resets')
                                                        <a href="{{URL::to('/cpanel/editar/'.$tabla.'/'.$registro->$campos[0])}}" class="btn btn-success btn-xs" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                                        <a href="{{URL::to('/cpanel/borrar/'.$tabla.'/'.$registro->$campos[0])}}" class="btn btn-danger btn-xs" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Borrar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
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
                                                            <button type="submit" class="btn btn-warning btn-xs" data-toogle="tooltip" rel="txtTooltip" data-placement="right" title="Grabar"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                                        @endif
                                                    </td>
                                                    @foreach($campos as $index => $campo)
                                                        <td><input name="{{$campo}}" value="{{ $registro->$campo }}" @if ($index == 0) readonly @endif/>@if ($campo == 'nombre_usuario' || $campo == 'password')<input name="{{$campo}}_old" value="{{ $registro->$campo }}" type="hidden"/>@endif</td>
                                                    @endforeach
                                                </form>
                                            </tr>
                                        @endforeach
                                    @endif
                            </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
