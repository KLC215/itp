@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="animated bounceInDown">

            <el-card class="box-card-children-desc"
                     style="background-color: #F9FAFC;">
                <sub-stage-progress-bar
                        :count-all-sub-arcade-childs="{{ $countAllSubArcadeChilds }}"
                        :attributes="{{ $subArcadeChilds }}">
                </sub-stage-progress-bar>
                <hr>
                <div class="media">
                    <div class="media-left media-middle">
                        <img class="media-object" src="{{ asset($subArcade['image']) }}"
                             alt="{{$subArcade['display_name']}}"
                             width="200px"
                             height="200px">
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading"><b>{{ $subArcade['display_name'] }}</b></h3>
                        <hr>
                        <h4>{!!$subArcade['description']!!}</h4>
                    </div>
                </div>
            </el-card>

            <div class="row">

                @foreach($subArcadeChilds as $subArcadeChild)

                    <a href="{{ route('arcades') . '/' . $subArcade['name'] . '/' . $subArcadeChild['name'] . '/intro'}}"
                       class="a-inherit-color col-md-4">
                        <el-card class="box-card-children-stage hvr-grow"
                                 style="cursor: pointer; background-color: #F9FAFC;">
                            <div class="row text-center">
                                <rating :stage="{{$subArcadeChild}}"></rating>
                            </div>
                            <div class="row">
                                <img src="{{ asset($subArcadeChild['image']) }}"
                                     alt="{{$subArcadeChild['display_name']}}"
                                     width="100px"
                                     height="100px"
                                     style="display: block;margin-left: auto;margin-right: auto;">
                            </div>
                            <p class="text-center"><b>{{ $subArcadeChild['display_name'] }}</b></p>
                            <table class="table">
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/coin_32.png') }}" alt="Coin" width="32"
                                             height="32">&nbsp;&nbsp;{{ $subArcadeChild['preferences']['coin'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/ic_exp_32.png') }}" alt="EXP" width="32"
                                             height="32">&nbsp;&nbsp;{{ $subArcadeChild['preferences']['exp'] }}
                                    </td>
                                </tr>
                            </table>
                        </el-card>
                    </a>

                @endforeach

            </div>

        </div>

    </div>

@endsection





