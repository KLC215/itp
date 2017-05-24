@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h1 class="panel-title">Leaderboard</h1>
            </div>
            <div class="panel-body">
                <leaderboard :attributes="{{ $users }}" inline-template v-cloak>
                    <div>
                        <h3>Top 3</h3>
                        <hr>
                        <top-three :user-assets="assets" :user-statistics="statistics"></top-three>
                        <hr>
                        <board :user-assets="assets" :user-statistics="statistics"></board>
                    </div>

                </leaderboard>
            </div>
        </div>
    </div>
@endsection