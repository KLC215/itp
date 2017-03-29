<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="content-bgc">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/lib.css') }}" rel="stylesheet">

		<!-- Scripts -->
		<script>
			window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
		</script>


		@yield('header-script')

	</head>
	<body>

		<div id="app" class="content-bgc">

			@include('layouts.navBar')

			<div>
				<transition name="fade" mode="out-in" appear>
					@yield('body-script')
					@yield('content')
				</transition>
			</div>

		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		@yield('header-script')
	</body>
</html>
