@section('header')
	<div class="header navbar navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="header-inner">

			<!-- BEGIN LOGO -->
			<a class="navbar-brand" href="/{{ config('app.section') }}">
				<span class="logo">@lang(env('APP_LANG_PREFIX') . '.' . env('APP_TITLE'))</span>
			</a>
			<!-- END LOGO -->

			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<img src="/assets/plugins/metronic/img/menu-toggler.png" alt=""/>
			</a>
			<!-- END RESPONSIVE MENU TOGGLER -->

			<!-- BEGIN TOP NAVIGATION MENU -->
			<ul class="nav navbar-nav pull-right">				
				<!-- BEGIN USER GROUP DROPDOWN -->
				@if (count(auth()->user()->roles()) > 1)
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<i class="fa fa-users" style="margin-top: 5px;"></i>
								<i class="fa fa-angle-down"></i>
						</a>
						@if (auth()->user()->roles())
							<ul class="dropdown-menu">
								@foreach(auth()->user()->roles() as $group => $groupId)
									<li @if (strtolower(config('app.section')) == strtolower($group))class="active"@endif>
										<a href="{{ str_finish(getCurrentURL('locale'), '/') . $group }}"> 
											@if (strtolower(config('app.section')) == strtolower($group))
												<i class="fa fa-check"></i>
											@else
												<i class="fa fa-unlock"></i>
											@endif
											@lang("language.{$group}")
										</a>
									</li>
								@endforeach
							</ul>	
						@endif
					</li>
				@endif
				<!-- END USER GROUP DROPDOWN -->

				<!-- BEGIN LANGUAGE DROPDOWN -->
				@if (count(config('app.locales')) > 1)
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="margin-top: 5px;">
							@if (File::exists(public_path() . '/images/flags/' . App::getLocale() . '.png')) 
								<img src="/images/flags/{{ App::getLocale() }}.png" alt="{{ App::getLocale() }}" title="{{ App::getLocale() }}">
							@else
								<i class="fa fa-language" style="margin-top: 5px; color: #fff;"></i>
							@endif	
							<i class="fa fa-angle-down"></i>
						</a>
						@if (config('app.locales')) 
							<ul class="dropdown-menu">
								@foreach(config('app.locales') as $kl => $locale)
									<li @if (App::getLocale() == $locale)class="active"@endif>
										<a href="/{{ $locale }}/{{ config('app.section') }}"> 
											@if (File::exists(public_path() . '/images/flags/' . $locale . '.png'))
												<img src="/images/flags/{{ $locale }}.png" alt="{{ $kl }}" title="{{ $kl }}">
											@else 
												@if (App::getLocale() == $locale)
													<i class="fa fa-check"></i>
												@else
													<i class="fa fa-lock"></i>
												@endif
											@endif	
											@lang('language.' . $kl)
										</a>
									</li>
								@endforeach
							</ul>	
						@endif
					</li>
				@endif
				<!-- END LANGUAGE DROPDOWN -->
				
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						@if (File::exists(config('upload.User') . Auth::id()))
							<img src="/pic/user/{{ Auth::id() . 'w29h29c1/' . str_random() }}.png?nocache=1" alt=""/>
						@else
							<img src="/assets/plugins/metronic/img/avatar.png" style="width: 29px; height: 29px;" alt=""/>
						@endif	
						<span class="username">{{ auth()->user()->name }}</span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						{{--<li>--}}
							{{--<a href="{{ getCurrentURL('section') . '/User/profile' }}">--}}
								{{--<i class="fa fa-user"></i> @lang('language.my profile')--}}
							{{--</a>--}}
						{{--</li>--}}
						<li class="divider"></li>
						<li>
							<a href="javascript:;" id="trigger_fullscreen">
								<i class="fa fa-arrows"></i> @lang('language.full screen')
							</a>
						</li>
						<li>
							<a href="extra_lock.html">
								<i class="fa fa-lock"></i> @lang('language.lock screen')
							</a>
						</li>
						<li>
						<a href="/auth/logout">
								<i class="fa fa-key"></i> @lang('language.logout')
							</a>
						</li>
					</ul>
				</li>
			<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<div class="clearfix"></div>
@show