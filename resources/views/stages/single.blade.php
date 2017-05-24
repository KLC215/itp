@extends('layouts.app')

@section('content')
    <div class="container">
        <steps-bar :data="{{ json_encode($steps) }}"></steps-bar>

        <question
                :question-data="{{ $randomQuestions }}"
                :answer-data="{{ json_encode($answers) }}"
                :badge-data="{{ json_encode($badges) }}"></question>
    </div>
@endsection