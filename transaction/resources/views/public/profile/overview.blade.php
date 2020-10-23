<div class="row">
	<div class="col-md-3">
		<ul class="list-unstyled profile-nav">
			<li>
				<div style="min-height: 287px;">
					@if (File::exists(config('upload.User') . auth()->id()))
						<img src="/pic/user/{{ auth()->id() . 'w308h287c1/' . str_random() }}.png?nocache=1" class="img-responsive" alt="">
					@else
						<img style="margin: 0 auto;" src="/images/icon/no-image.png" class="img-responsive" alt="">
					@endif	
				</div>	
				{{-- <a href="#" class="profile-edit">{{ trans('language.edit') }}</a> --}}
			</li>
			<li>
				<a href="#">{{ trans('language.messages') }}
					<span>3</span>
				</a>
			</li>
			<li>
				<a href="#">{{ trans('language.settings') }}</a>
			</li>
		</ul>
	</div>
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-8 profile-info">
				<h1>{{ auth()->user()->info()->fullname }}</h1>
				<p>{{ auth()->user()->username }}</p>
				<p>{{ trans('language.' . auth()->user()->info()->gender) }}</p>
				<ul class="list-inline">
					@if (auth()->user()->email)
						<li>												
							<i class="fa fa-envelope-o"></i> 
							<a href="mailto: {{ auth()->user()->email }}">
								{{ auth()->user()->email }}
							</a>
						</li>
					@endif

					@if (auth()->user()->info()->birthday > 0)
						<li>
							<i class="fa fa-calendar"></i> 
							{{ FarsiLib::g2jDate(auth()->user()->info()->birthday, true) }}
						</li>
					@endif
				</ul>

				@if (auth()->user()->info()->tel or auth()->user()->info()->mobile)
					<ul class="list-inline">
						@if (auth()->user()->info()->tel)
							<li>												
								<i class="fa fa-phone"></i> 
								<span style="direction: ltr;display: inline-block;">
									{{ FarsiLib::en2faDigit(auth()->user()->info()->tel) }}
								</span>
							</li>
						@endif
						@if (auth()->user()->info()->mobile)
							<li>												
								<i class="fa fa-mobile" style="font-size: 17px;"></i> 
								<span style="direction: ltr;display: inline-block;">
									{{ FarsiLib::en2faDigit(auth()->user()->info()->mobile) }}
								</span>
							</li>
						@endif	
					</ul>
				@endif

				@if (auth()->user()->info()->address)
					<ul class="list-inline">
						<li>
							<i class="fa fa-map-marker"></i> 
							{{ auth()->user()->info()->address }}
						</li>
					</ul>
				@endif
			</div>
		</div>
	</div>
</div>