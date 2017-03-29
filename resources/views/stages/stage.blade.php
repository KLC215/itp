@extends('layouts.app')

@section('content')

	<div class="container">

		@if($steps['arcade'] == 'while-loop')

			<while-loop :questions="{{ json_encode($questions) }}"></while-loop>

		@endif

	</div>

@endsection