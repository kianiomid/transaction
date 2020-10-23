<div class="change-password-result"></div>
<form action="{{ getCurrentURL('controller') . '/changePassword' }}" method="post"  enctype="multipart/form-data" class="changepassword-form"> 
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<div class="form-group">
		<div class="input-icon">
			<i class='fa fa-lock'></i>
			<input type="password" name="password" class="form-control" placeholder="@lang('language.current password')" >
		</div>
	</div>

	<div class="form-group">
		<div class="input-icon">
			<i class='fa fa-lock'></i>
			<input type="password" name="newpassword" class="form-control" id="new-password" placeholder="@lang('language.new password')" >
		</div>	
	</div>

	<div class="form-group">
		<div class="input-icon">
			<i class='fa fa-lock'></i>
			<input type="password" name="retypepassword" class="form-control" placeholder="@lang('language.re-type new password')" >
		</div>	
	</div>
	<div class="margin-top-10"> 
		<div class="note note-info text-right">
			<button type="submit" class="btn btn-success">
				@lang('language.change password')
			</button>
		</div>
	</div>
</form>

<script>
	window.addEventListener('load', function() {
		App.changePassword($('.changepassword-form'));
	});
</script>