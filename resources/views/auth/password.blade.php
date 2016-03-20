@extends('app')

@section('content')
<div id="contenido" class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h1 class="panel-title">Establecer nueva clave</h1></div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
						{!! csrf_field() !!}

						<div class="form-group">
							<label for="email" class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 control-label">E-Mail</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-10 col-xs-offset-1">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Aquí te enviaremos el enlace para que recuperes tu clave. Debe coincidir con el email que usaste en tu registro.">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-10 col-xs-offset-1">
								<button type="submit" class="btn btn-success" data-toogle="tooltip" rel="jslicense" data-placement="bottom" title="Pulsa aquí, comprueba tu correo y sigue las instrucciones.">
									Enviar link para nueva clave
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
