@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row profile">
            @include('profile.sidebar', ['user' => $user, 'isMe' => $isMe])
            <div class="col-md-9">
                <div class="profile-content">
                    <h3>Account Settings</h3>
                    <hr>
                    @include('flash::message')
                    <form class="form-horizontal" action="{{ route('updatePassword') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="oldPassword" class="col-sm-2 control-label">Old Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="oldPassword" id="oldPassword"
                                       placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPassword" class="col-sm-2 control-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="newPassword" id="newPassword"
                                       placeholder="New Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-2 control-label">Confirm New Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirmPassword" id="nonfirmPassword"
                                       placeholder="Confirm New Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection