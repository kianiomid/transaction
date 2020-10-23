 <meta charset="utf-8"/>
<title>
    {{ config('app.section') ? trans('language.' . config('app.section')) . ' | ':  '' }}
    {{ @$customTitle ?: (@$title ? (preg_match('/^language\./', $title) ? trans($title):  trans(config('custom.site.lang', 'language') . '.' . $title)): @$customTitle) }}
    {{ @$title2 ? (' | ' . $title2) :  ''}}
</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />

@var('dir', config('app.dir', 'ltr'))
@assets('fontface')

@if ($dir == 'rtl')
    @assets('core-css-rtl')
@else
    @assets('core-css')
@endif

@assets('theme-css' . ($dir == 'rtl' ? ('-' . $dir):  ''))

@assets('plugins-admin-css')
@if ($dir == 'rtl')
    @assets('plugins-admin-rtl-css')
@endif

@assets('plugin-css' . ($dir == 'rtl' ? ('-' . $dir):  ''))->config(array('pipeline' => compareAssets(Assets::getCss())))

@if ($dir == 'rtl')
    @assets('core-js')
    @assets('core-js-rtl')->config(array('pipeline' => compareAssets(Assets::getJs())))
@else
    @assets('core-js')->config(array('pipeline' => compareAssets(Assets::getJs())))
@endif


<link href="{{ asset('/assets/plugins/metronic/css/themes/' . config('app.theme', 'default') . '.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
{!! Assets::css() !!}
{!! Assets::js() !!}

<noscript>
    <link rel="stylesheet" href="{{ asset('/assets/plugins/jquery-file-upload/css/jquery.fileupload-noscript.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/jquery-file-upload/css/jquery.fileupload-ui-noscript.css') }}">
</noscript>

<script src="{{ asset('/assets/cache/' . jsLanguage()) }}"></script>
<script>
    var section = "{{ config('app.section') }}", controller = "{{ config('app.controller') }}", action = "{{ config('app.action') }}",  locale = "{{ config('app.localization') }}";
    var lang = "{{ App::getLocale() }}", environment = '{{ App::environment() }}', random = "{{ config('app.random') }}";
    window.dir =  "{{ config('app.dir', 'ltr') }}";

    jQuery(document).ready(function() {
        App.init(); // initlayout and core plugins
        UIExtendedModals.init();

        @if (!Request::ajax() and @$viewEdit)
            $('.edit-responsive .modal-header .close').click(function(event) {
                window.location.href = "{{ Lib::getCurrentURL('controller') }}";
            });
            $('.edit-responsive form').submit(function(event) {
                window.location.href = "{{ Lib::getCurrentURL('controller') }}";
            });
        @endif
    });
</script>