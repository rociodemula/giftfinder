@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Establecer nueva clave</div>
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
							<label class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">E-Mail</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">Clave</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="password" class="form-control" name="password" autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-offset-1 col-xs-10 control-label">Confirmar clave</label>
							<div class="col-md-6 col-md-offset-0 col-sm-6 col-sm-offset-0 col-xs-offset-1 col-xs-10 ">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-4 col-xs-offset-1 col-xs-10 ">
								<button type="submit" class="btn btn-success">
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
