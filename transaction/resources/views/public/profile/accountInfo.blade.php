<div class="user-info-result"></div>
<form action="{{ getCurrentURL('controller') . '/updateInfo' }}" method="post"  enctype="multipart/form-data" onsubmit="App.ajaxRequest(this, {overlay: {'active':  true}, 'resultObject': 'user-info-result'}); return false;" class="update-userinfo-form"> 
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		
		@include('admin.edit.partial.userInfo')

	<div style="margin-top: 30px;" class="col-md-12">	
		<div class="note note-info text-right"> 
			<button type="submit" name="submit_frm" class="btn btn-success">@lang('language.update')</button>
	    </div>
	</div>    
</form>