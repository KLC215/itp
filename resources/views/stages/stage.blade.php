@extends('layouts.app')

@section('content')

    <div class="container">

        <steps-bar :data="{{ json_encode($steps) }}" ></steps-bar>

        @if($intro)
            @include('stages.intro', ['subArcadeChild' => $subArcadeChild])
        @else
            @include('stages.start', ['questions' => $questions, 'answers' => $answers, 'subArcadeChild' => $subArcadeChild, 'badges' => $badges])
        @endif
    </div>

@endsection