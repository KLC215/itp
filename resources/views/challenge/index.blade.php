@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="animated bounceInDown">

            @foreach($challenges as $challenge)
                <div class="row">
                    <a href="{{ route('challenges') . '/'. $challenge['name'] . '/start' }}"
                       class="a-inherit-color"
                       style="{{ $challenge->lock ? 'pointer-events: none;cursor: default;filter: grayscale(100%);' : '' }}">
                        <el-card class="box-card-children-root hvr-grow"
                                 style="cursor: pointer; background-color: #F9FAFC;">
                            <el-progress
                                    :text-inside="true"
                                    :stroke-width="18"
                                    :percentage="0"
                                    status="success">
                            </el-progress>
                            <hr>
                            <div class="media">
                                <div class="media-left media-top">
                                    <img class="media-object" src="{{ asset($challenge['image']) }}"
                                         alt="{{$challenge['display_name']}}"
                                         width="200px"
                                         height="200px">
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading"><b>{{ $challenge['display_name'] }}</b></h3>
                                    <hr>
                                    <h4>{!!$challenge['description']!!}</h4>
                                </div>
                            </div>
                        </el-card>
                    </a>
                </div>
            @endforeach

        </div>

    </div>

@endsection