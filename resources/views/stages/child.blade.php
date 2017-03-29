@extends('layouts.app')

@section('content')

	<div class="container">

		<div class="animated bounceInDown">

			<el-card class="box-card-children-desc"
					 style="background-color: #F9FAFC;">
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

			<div class="row">

				@foreach($childStages as $childStage)


					@if (Request::segment(2) == 'tutorial')
						<a href="{{ route('arcades') . '/' . $stage['name'] . '/' . $childStage['name'] . '/intro'}}"
						   class="a-inherit-color col-md-4">
							@else
								<a href="{{ route('arcades') . '/' . $stage['name'] . '/' . $childStage['name'] . '/start'}}"
								   class="a-inherit-color col-md-4">
									@endif

									<el-card class="box-card-children-stage hvr-grow"
											 style="cursor: pointer; background-color: #F9FAFC;">
										<div class="row text-center">
											<rating :stage="{{$childStage}}"></rating>
										</div>
										<div class="row">
											<img src="{{ asset($childStage['image']) }}"
												 alt="{{$childStage['display_name']}}"
												 width="100px"
												 height="100px"
												 style="display: block;margin-left: auto;margin-right: auto;">
										</div>
										<p class="text-center"><b>{{ $childStage['display_name'] }}</b></p>

										<div class="row">
											<span class="badge">Coin</span>{{ $childStage['preferences']['coin'] }}
											<span class="eo-20 eo-money_mouth_face"></span>
										</div>
										<div class="row">
											<span class="badge">EXP</span>{{ $childStage['preferences']['exp'] }}
											<span class="eo-20 eo-heart_eyes"></span>
										</div>

									</el-card>
								</a>

						@endforeach

			</div>

		</div>

	</div>

@endsection





