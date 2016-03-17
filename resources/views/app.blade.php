<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Giftfinder</title>
	<link rel="shortcut icon" href="/img/logo.jpg">

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- Scripts -->
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="/js/script.js"></script>
	<!-- Librería de Google Maps API, necesaria para Directions-->
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<!-- Librería de geolocalización en javascript-->
	<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>

	<!--Este script funciona bien para Directions, pero no para maps ni markers:
	<script src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM&signed_in=true&callback=initMap"></script>-->
	<!--Este script no carga siempre, la geolocalización de perfil la hace bien, pero en búsquedas da error
	ReferenceError: google is not defined (ver http://stackoverflow.com/questions/33495879/uncaught-referenceerror-google-is-not-defined-at-google-maps-marker)
	<script async defer src="https://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM&signed_in=true&callback=initMap"></script>-->
	<!--Este script da problemas, no carga las distancias <script
			src="https://maps.googleapis.com/maps/api/js?callback=initMap&signed_in=true&key=AIzaSyCAdE-mIj8O4nPF2RYcy2uEamgDHPmXHKM" async defer>
	</script>-->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>


	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<a href="http://demosdata.com/"><img class="banner img-responsive center-block" height="70" src="/img/banner.jpg" height="35"></img></a>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}"><img src="/img/logo.jpg" height="35" width="35""></img>
					</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar">
				<!--<ul class="nav navbar-nav">
					<li><a href="{{ url('/home') }}">Home</a></li>
				</ul>-->
				<ul class="nav navbar-nav">
					<li @if (Request::is('/')) class="active" @endif>
						<a href="{{ url('/') }}">Inicio</a>
					</li>
					@if(!auth()->guest())
						<li @if (Request::is('perfil*')) class="active" @endif>
							<a href="{{ url('/perfil') }}">Perfil</a>
						</li>
						<li @if (Request::is('busqueda*')) class="active" @endif>
							<a href="{{ url('/busqueda') }}">Búsqueda</a>
						</li>
						<li @if (Request::is('contacto*')) class="active" @endif>
							<a href="{{ url('/contacto') }}">Contacto</a>
						</li>
					@endif
					@if(!auth()->guest() && (auth()->user()->tipo == 'admin'))
						<li @if (Request::is('cpanel*')) class="active" @endif>
							<a href="{{ url('/cpanel') }}">Panel de control</a>
						</li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if(auth()->guest())
						@if(!Request::is('auth/login'))
							<li><a href="{{ url('/auth/login') }}">Identifícate</a></li>
						@endif
						@if(!Request::is('auth/register'))
							<li><a href="{{ url('/auth/register') }}">Regístrate</a></li>
						@endif
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Bienvenido, {{ auth()->user()->nombre_usuario }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Salir</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
<footer class="navbar navbar-default navbar-fixed-bottom">
	<div class="container-fluid">
			<div class="collapse navbar-collapse" id="footer">
				<ul class="nav navbar-nav">
					<li  @if (Request::is('condiciones*')) class="active" @endif>
						<a href="{{ url('/condiciones') }}">Condiciones de uso</a>
					</li>
					<li @if (Request::is('ayuda*')) class="active" @endif>
						<a href="{{ url('/ayuda') }}">Ayuda / Manuales</a>
					</li>
					<li @if (Request::is('derechos*')) class="active" @endif>
						<a href="{{ url('/derechos') }}">Derechos de autor</a>
					</li>
				</ul>
				<ul class="nav navbar-nav pull-right"><li><a href="mailto:rociodemula@demosdata.com">&copy; 2016 - Rocío de Mula</a></li></ul>
			</div>
	</div>
</footer>


	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
