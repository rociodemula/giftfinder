@extends('app')
{{-- Página de bienvenida al sistema. No es necesario estar logado para llegar aquí --}}
@section('content')
    <div class="container">
        <div class="content">
            <div><h1>Bienvenida al sistema</h1></div>
            <div>Entrada al sistema sin necesidad de estar logado.</div>
            <div>Página de llegada.</div>
            <div class="quote">{{ Inspiring::quote() }}</div>
        </div>
    </div>
@stop
