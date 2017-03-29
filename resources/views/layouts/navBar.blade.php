<nav class="navbar navbar-default navbar-fixed-top {{ Auth::guest() ? 'navbar-inverse' : '' }}">
	<div class="container">
		<div class="navbar-header">

			<!-- Collapsed Hamburger -->
			<button type="button"
					class="navbar-toggle collapsed"
					data-toggle="collapse"
					data-target="#app-navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ url('/') }}">

				<h4>
					<i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
					{{ config('app.name', 'Laravel') }}
					<i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
				</h4>

			</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">

			@if (!Auth::guest())
				{{-- Left Side of Navbar --}}
				<ul class="nav navbar-nav content-mt">

					{{-- Leaderboard --}}
					<li>
						<a href="#">
							<div class="eo-16 eo-trophy"></div>
							<b>LeaderBoard</b>
						</a>
					</li>

					{{-- Wiki --}}
					<li>
						<a href="#">
							<div class="eo-16 eo-book"></div>
							<b>Wiki</b>
						</a>
					</li>

				</ul>
		@endif

		<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">

				<!-- Authentication Links -->
				@if (Auth::guest())
					<li><a @click="signInModalConfig.show = true">Sign In</a></li>
					<sign-in :config="signInModalConfig"></sign-in>
				@else

					{{-- Store --}}
					<li>
						<a href="#" class="content-mt">
							<div class="eo-16 eo-department_store"></div>
							<b>Store</b>
						</a>
					</li>

					<li class="dropdown">
						<a class="dropdown-toggle"
						   data-toggle="dropdown"
						   role="button"
						   aria-expanded="true">
							<img src="{{ Auth::user()->avatar }}"
								 class="img-circle"
								 width="40"
								 height="40"/>
							<span class="caret"></span>
						</a>

						<ul class="dropdown-menu" role="menu">

							{{-- Avatar and Username --}}
							<li>
								<img src="{{ Auth::user()->avatar }}"
									 class="img-circle content-ml"
									 width="40"
									 height="40"/>
								<span class="content-pr"></span>{{ Auth::user()->name }}
							</li>

							{{-- Coin and Store--}}
							<li>
								<div class="content-ml">
									<h4>
										<span class="label label-primary">
											<div class="eo-16 eo-level_slider"></div>
											{{ Auth::user()->exp }}
										</span>
									</h4>
									<h4>
										<span class="label label-primary">
											<div class="eo-16 eo-heavy_dollar_sign"></div>
											{{ Auth::user()->coin }}
										</span>
									</h4>
								</div>
							</li>

							<li role="separator" class="divider"></li>

							<li>
								<a href="#">
									<div class="eo-16 eo-bust_in_silhouette content-mr"></div>
									<b>Profile</b>
								</a>
							</li>

							<li>
								<a href="#">
									<div class="eo-16 eo-ring content-mr"></div>
									<b>Badges</b>
								</a>
							</li>

							<li role="separator" class="divider"></li>

							<li>
								<a href="{{ route('logout') }}"
								   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									{{--<span class="glyphicon glyphicon-log-out content-pr"--}}
									{{--aria-hidden="true"></span>--}}
									<div class="eo-16 eo-door content-mr"></div>
									<b>Sign out</b>
								</a>

								<form id="logout-form"
									  action="{{ route('logout') }}"
									  method="POST"
									  style="display: none;">
									{{ csrf_field() }}
								</form>
							</li>

						</ul>
					</li>

				@endif

			</ul>
		</div>
	</div>
</nav>
