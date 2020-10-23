<!-- BEGIN PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            @if (@$title && preg_match('/^language\./', $title)) 
                 @lang($title)
            @elseif (@$title)
                @lang(env('APP_LANG_PREFIX') . '.' . $title)
            @else 
                {{ @$customTitle }} 
            @endif
        </h3>
        <ul class="page-breadcrumb breadcrumb">

            @if (@$actionlist)
                <li class="btn-group">
                    <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                    <span> @lang('language.actions') </span>
                    <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        @foreach (@$actionlist as $action)
                            <li>
                                <a href="{{ $action.link }}">{{ $action.name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif

            <li>
                <i class="fa fa-home"></i>
                @if (@$title and strtolower(config('app.controller')) != 'home')
                    <a href="{{ Lib::getCurrentURL('section') . '/Home' }}">@lang('language.home')</a>
                    <i class="fa @if(config('app.dir') == 'rtl') fa-angle-left @else fa-angle-right @endif"></i>
                @else
                    <i class="fa @if(config('app.dir') == 'rtl') fa-angle-left @else fa-angle-right @endif"></i>
                @endif    
            </li>
            @if (@$title and @$title2)
                <li>
                    @if (@$link)
                        <a href="{{ $link }}">
                            @lang(preg_match('/^language\./', $title) ? $title:  env('APP_LANG_PREFIX') . '.' . @$title)
                        </a>
                    @else
                        <span>
                            @lang(preg_match('/^language\./', $title) ? $title:  env('APP_LANG_PREFIX') . '.' . @$title)
                        </span>
                    @endif

                    <i class="fa @if(config('app.dir') == 'rtl') fa-angle-left @else fa-angle-right @endif"></i>
                    @if (@$link2)
                        <a href="{{ $link2 }}">{{ @$title2 }}</a>
                    @else
                        <span>{{ @$title2 }}</span>
                    @endif
                </li>
            @elseif (@$title and config('app.controller') != 'home')
                <li>
                    <span>
                        @lang(preg_match('/^language\./', $title) ? $title:  env('APP_LANG_PREFIX') . '.' . @$title)
                    </span>
                </li>
            @endif

            <li class="pull-right">
                <div id="dashboard-report-range" class="dashboard-date-range tooltips" {{--data-placement="top" data-original-title="Change dashboard date range"--}} style="display: block;background: #bfcad1; cursor: default;">
                    <i class="fa fa-calendar"></i>
                    <span>{{ trans('language.today') . ' ' . (config('app.dir') == 'ltr' ? date('l d F Y - H:i:s') : (convertDigit(FarsiLib::jDate('l d F ماه Y - ') . date('H:i:s')))) }}</span>
                    {{-- <i class="fa fa-angle-down"></i> --}}
                </div>
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<!-- END PAGE HEADER-->