@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
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
                        @endif
                        <form class="form-horizontal" role="form" method="POST" action="/cpanel">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-3">
                                        <label class="control-label">Elige la tabla a modificar</label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="tabla">
                                            <option>Tabla</option>
                                            @foreach ($tablas as $item)
                                                <option>@if($item->Tables_in_giftfinder == old('tabla'))selected @endif{{$item->Tables_in_giftfinder}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-1">
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
                                <div class="col-md-12">
                                    <h4>Contenido de la tabla: {{ $tabla }}</h4>
                                </div>
                            </div>
                            <table class="table table-responsive table-striped">
                                @if ($resultados != null)
                                    <thead>
                                    <td>Acciones</td>
                                        @foreach($campos as $campo)
                                            <td>{{ $campo }}</td>
                                        @endforeach
                                    </thead>
                                    @foreach($resultados as $registro)
                                        <tr @if ($editar && ($registro->$campos[0] == $id)) class="hidden" @endif>
                                            <td><a href="{{URL::to('/cpanel/editar/'.$tabla.'/'.$registro->$campos[0])}}" class="btn btn-success btn-xs">Editar</a>
                                            <a href="{{URL::to('/cpanel/borrar/'.$tabla.'/'.$registro->$campos[0])}}" class="btn btn-warning btn-xs">Borrar</a></td>
                                            @foreach($campos as $campo)
                                                    <td>{{ $registro->$campo }}</td>
                                            @endforeach
                                        </tr>
                                        <tr @if (!$editar || ($registro->$campos[0] != $id)) class="hidden" @endif>
                                            <form method="POST" action="/cpanel/grabar">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="tabla" value="{{$tabla}}"/>
                                                <input type="hidden" name="id" value="{{$registro->$campos[0]}}"/>
                                                <td><button type="submit" class="btn btn-success btn-xs">Grabar</button></td>
                                                @foreach($campos as $campo)
                                                    <td><input name="{{$campo}}" value="{{ $registro->$campo }}"/></td>
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
