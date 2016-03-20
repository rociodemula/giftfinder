@extends('app')

@section('content')
<div id="contenido" class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h1 class="panel-title">Establecer nueva clave</h1></div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label for="email" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">E-Mail</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Este es tu email.">
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">Clave</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="password" class="form-control" name="password" autofocus data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Teclea tu nueva clave. Recuerda: mínimo, 6 caracteres.">
							</div>
						</div>

						<div class="form-group">
							<label for="password_confirmation" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">Confirmar clave</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="password" class="form-control" name="password_confirmation" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Teclea de nuevo la clave para confirmarla.">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-offset-1 col-xs-10 ">
								<button type="submit" class="btn btn-success" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Pulsa aquí y tu nueva clave quedará activada.">
									Establecer nueva clave
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
