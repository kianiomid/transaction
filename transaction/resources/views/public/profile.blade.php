@section('content')
	<!-- BEGIN PAGE CONTENT-->
	<div class="row profile">
		<div class="col-md-12">
			<!--BEGIN TABS-->
			<div class="tabbable tabbable-custom tabbable-full-width">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab" data-url="{{ getCurrentURL('controller') . '/profile' }}" 
							onclick="if (!$(this).closest('li.active').length) { App.ajaxRequest(this, {overlay: {active: true, resultObject: true}, 'resultObject': $('.account-overview')}); }">
							{{ trans('language.overview') }}
						</a>
					</li>
					<li><a href="#tab_1_3" data-toggle="tab">{{ trans('language.user account') }}</a></li>
					{{-- <li><a href="#tab_1_6" data-toggle="tab">{{ trans('language.help') }}</a></li> --}}
				</ul>
				<div class="tab-content">
					
					<!--tab_1_1-->
					<div class="tab-pane active" id="tab_1_1">
						<div class="account-overview">
							@include('public.profile.overview')
						</div>						
					</div>

					<!--tab_1_2-->
					<div class="tab-pane" id="tab_1_3">
						<div class="row profile-account">
							<div class="col-md-3">
								<ul class="ver-inline-menu tabbable margin-bottom-10">
									<li class="active">
										<a data-toggle="tab" href="#tab_1-1">
											<i class="fa fa-cog"></i> {{ trans('language.personal info') }}
										</a>
										<span class="after"></span>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_2-2">
											<i class="fa fa-picture-o"></i> {{ trans('language.change avatar') }} 
										</a>
									</li>
									<li>
										<a data-toggle="tab" href="#tab_3-3">
											<i class="fa fa-lock"></i> {{ trans('language.change password') }} 
										</a>
									</li>
									{{-- <li>
										<a data-toggle="tab" href="#tab_4-4">
											<i class="fa fa-eye"></i> {{ trans('language.privacy settings') }} 
										</a>
									</li> --}}
								</ul>
							</div>
							<div class="col-md-9">
								<div class="tab-content">
									<div id="tab_1-1" class="tab-pane active">
										<div class="account-info">
											@include('public.profile.accountInfo')
										</div>	
									</div>
									
									<div id="tab_2-2" class="tab-pane" style="min-height: 300px;">
										<div class="account-image">											
											@include('public.profile.accountImage')
										</div>
									</div>

									<div id="tab_3-3" class="tab-pane" style="min-height: 300px;">
										@include('public.profile.accountChangePassword')
									</div>

									<div id="tab_4-4" class="tab-pane">
										@include('public.profile.accountPrivacy')
									</div>
								</div>
							</div>
							<!--end col-md-9-->
						</div>
					</div>
					{{-- <!--end tab-pane-->
					<div class="tab-pane" id="tab_1_6">
						@include('public.profile.help')
					</div>
					<!--end tab-pane--> --}}
				</div>
			</div>
			<!--END TABS-->
		</div>
	</div>
	<link href="{{ asset('/assets/plugins/metronic/css/pages/profile' . (config('app.dir') == 'rtl' ? '-rtl' : '') . '.css') }}" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript">
		$('*[data-toggle="tab"]').click(function () {
			App.initAjax();
		});
	</script>
@stop	