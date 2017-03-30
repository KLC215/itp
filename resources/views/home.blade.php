@extends('layouts.app')

@section('content')
	<div class="container">

		{{-- Available stages --}}
		<div class="animated bounceInDown">

			@foreach($stages as $stage)
				<div class="col-md-6 col-xs-12">
					<a href="{{ route($stage['name']) }}" class="a-inherit-color">
						<el-card class="box-card-parent hvr-grow"
								 style="cursor: pointer; background-color: #F9FAFC;">
							<el-progress
									:text-inside="true"
									:stroke-width="18"
									:percentage="0"
									status="success">
							</el-progress>
							<hr>
							<div class="media">
								<div class="media-left">
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

		<!-- Locked Stage-->
		<el-card class="box-card" style="background-color: #475669;">
			<div class="text-center">
				<!--<i class="fa fa-cog fa-spin fa-5x fa-fw" style="color: #00b89c"></i>-->
				<!--<i v-emoji-render:data="emoji.lock"></i>-->
				<i class="eo-64 eo-lock" style="margin-top: 20%;"></i>
			</div>
		</el-card>
	</div>

@endsection
