<!DOCTYPE html>
<html class="full" lang="{{ config('app.locale') }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<!-- Scripts -->
		<script>
			window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
		</script>

	</head>
	<body>

		<div id="app" class="content">

			@include('layouts.navBar')

			<h1 style="color: white">Learn Loop, Happy Loop</h1>

			<button class="btn btn-success btn-lg" @click="signUpModalConfig.show = true">Sign Up</button>

			<sign-up :config="signUpModalConfig"></sign-up>

		</div>

		<script src="{{ asset('js/app.js') }}"></script>

	</body>
</html>
