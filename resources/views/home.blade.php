@extends('app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="title">Página principal usuario (home) public_html</div>
            <table class="table table-responsive table-striped">
                <thead>
                    <td>id</td>
                    <td>name</td>
                    <td>address</td>
                    <td>edit</td>
                    <td>delete</td>
                </thead>
                @for($i = 0; $i < 10; $i++)
                <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>address</td>
                    <td>edit</td>
                    <td>remove</td>
                </tr>
                @endfor

            </table>
        </div>
    </div>
@stop
