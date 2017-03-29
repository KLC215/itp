@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="animated bounceInDown">

			@foreach($stages as $stage)
				<div class="{{ $stage['name'] == 'tutorial' ? 'col-md-4 col-md-offset-4 col-xs-12 ' : 'col-md-4 col-md-offset-4 col-xs-12 ' }}">

					<a href="{{ route('arcades') . '/'. $stage['name'] }}"
					   class="a-inherit-color">

						<el-card class="box-card-children-root hvr-grow"
								 style="cursor: pointer; background-color: #F9FAFC;">
							<el-progress
									:text-inside="true"
									:stroke-width="18"
									:percentage="100"
									status="success">
							</el-progress>
							<hr>
							<div class="media">
								<div class="media-left media-middle">
									<img class="media-object" src="{{ asset($stage['image']) }}"
										 alt="{{$stage['display_name']}}"
										 width="100px"
										 height="100px">
								</div>
								<div class="media-body">
									<h3 class="media-heading"><b>{{ $stage['display_name'] }}</b></h3>
									<hr>
									<h4>{!!$stage['description']!!}</h4>
								</div>
							</div>
						</el-card>
					</a>
				</div>
			@endforeach
		</div>

	</div>

@endsection