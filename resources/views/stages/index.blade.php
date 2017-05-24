@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="animated bounceInDown">

            @foreach($stages as $stage)
                <div class="row">
                    {{--				<div class="{{ $stage['name'] == 'tutorial' ? 'col-md-4' : 'col-md-4' }}">--}}

                    @if(!$stage->single)
                        <a href="{{ route('arcades') . '/'. $stage['name'] }}"
                           class="a-inherit-color">
                            @else
                                <a href="{{ route('arcades') . '/'. $stage['name'] . '/start' }}"
                                   class="a-inherit-color"
                                   style="{{ $stage->lock ? 'pointer-events: none;cursor: default;filter: grayscale(100%);' : '' }}">
                                    @endif

                                    <el-card class="box-card-children-root hvr-grow"
                                             style="cursor: pointer; background-color: #F9FAFC;">
                                        <div class="media">
                                            <div class="media-left media-top">
                                                <img class="media-object" src="{{ asset($stage['image']) }}"
                                                     alt="{{$stage['display_name']}}"
                                                     width="200px"
                                                     height="200px">
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