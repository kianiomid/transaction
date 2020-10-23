<!--[if lt IE 9]>
    <script src="{{ asset('/assets/plugins/respond.min.js') }}" ></script>
    <script src="{{ asset('/assets/plugins/excanvas.min.js') }}" ></script>
    <script src="{{ asset('/assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js') }}" ></script>
<![endif]-->

@var('dir', config('app.dir', 'ltr')) 
{{--@resetAssets()--}}
    {{----}}
{{--@assets('plugin-admin-js')--}}
{{--@assets('plugin-js')    --}}
{{--@assets('app-js')->config(array('pipeline' => compareAssets(Assets::getJs())))--}}

{{--{!! Assets::js() !!}--}}

@if ($dir == 'rtl')     
    <script src= "{{ asset('/assets/plugins/select2/select2_locale_' . App::getLocale() . '.js') }}"></script>
@endif

<script type="text/javascript">
	if (typeof App != 'undefined') {
		App.initAjax();
	}
</script>