<form action="{{ getCurrentURL('controller') . '/updateInfo' }}" method="post" enctype="multipart/form-data" onsubmit="updateImageForm(this);" target="imageIframe"> 
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	@include('admin.edit.partial.userImage')
	
	<div style="margin-top: 30px;">
		<div class="note note-info text-right"> 
			<button type="submit" class="btn btn-success">
				@lang('language.update')
			</button>
		</div>
	</div>
</form>

<iframe class="image-iframe hidden" name="imageIframe" src="" frameborder="0" 
	height="250" width="100%" scrolling="no">
</iframe>

<script>
	function updateImageForm(frm) {
		var form = $(frm);
		if (!form.length) return;
		var url = "{{ getCurrentURL('controller') . '/loadImage' }}";
		App.createOverlay($('.account-image'), {overlay: {'active': true, resultObject: $('.account-image')}});
		$('.image-iframe').off('load').on('load', function() { 
			App.ajaxRequest(form, {'url': url,  overlay: {active: true, resultObject: true},
				 'resultObject': $('.account-image')});
		});
	}
</script>
