<div class="col-md-3">
    <div class="profile-sidebar">
        <!-- SIDEBAR USERPIC -->
        <div class="profile-userpic">
            <img src="{{ $user->avatar }}"
                 class="img-responsive" alt="{{ $user->name }}">
        </div>
        <!-- END SIDEBAR USERPIC -->
        <!-- SIDEBAR USER TITLE -->
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                {{ $user->name }}
            </div>
            <div class="profile-usertitle-job">

            </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <p><img src="{{asset('/images/coin_32.png')}}" alt="Coin">&nbsp;&nbsp;{{ $user->coin }}</p>
            <p><img src="{{asset('/images/ic_exp_32.png')}}" alt="Exp">&nbsp;&nbsp;{{ $user->exp }}</p>
            <p><h6>Joined {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</h6></p>
        </div>
        <!-- END SIDEBAR BUTTONS -->
        <!-- SIDEBAR MENU -->
        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <a href="{{ route('profileIndex') }}">
                        <i class="glyphicon glyphicon-home"></i>
                        Profile </a>
                    @if($isMe)
                        <a href="{{ route('resetPassword') }}">
                            <i class="glyphicon glyphicon-user"></i>
                            Account Settings </a>
                    @endif
                </li>
            </ul>
        </div>
        <!-- END MENU -->
    </div>
</div>