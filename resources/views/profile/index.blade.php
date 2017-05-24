@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row profile">
            @include('profile.sidebar', ['user' => $user, 'isMe' => $isMe])
            <div class="col-md-9">
                <div class="profile-content">
                    <profile :user-statistics="{{ $statistics }}"
                             :user-badges="{{ $badges }}"
                             :user-history="{{ $logs }}"
                             :user-is-me="{{ $isMe? 1: 0 }}"
                             :all-badges="{{ $allBadges }}">
                    </profile>
                </div>
            </div>
        </div>
    </div>
@endsection