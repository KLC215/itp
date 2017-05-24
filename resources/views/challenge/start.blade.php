@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-xs-6">
                @if($selectedChallenge->name == 'time-limited-challenge')
                    <timer :functional-data="{{ json_encode($selectedChallenge->preferences)  }}"></timer>
                @elseif($selectedChallenge->name == 'carefully-challenge')
                    <health-bar :functional-data="{{ json_encode($selectedChallenge->preference) }}"></health-bar>
                @endif
            </div>
            <div class="col-xs-6">
                <panel :item-data="{{ $items }}"></panel>
            </div>
        </div>

        <hr>
        <challenge :question-data="{{ $questions }}"
                   :answer-data="{{ json_encode($answers) }}"
                   :challenge-data="{{ $selectedChallenge }}"
                   :badge-data="{{ json_encode($badges) }}">
        </challenge>


    </div>

@endsection