<div class="portlet-title">
    <div class="caption">
        <i class="fa fa-{{ @$toolbarIcon ? @$toolbarIcon:  'globe' }}"></i>
        @if (@$customToolbarTitle)
            {{ @$customToolbarTitle }}
        @else
            @if (config('app.dir') == 'rtl')
                @lang('language.list of')
            @endif    
            @if (@$title2)
                {{ $title2 }}
            @elseif (@$title)
                @lang(preg_match('/^language\./', $title) ? $title:  (env('APP_LANG_PREFIX') . '.' . $title))
            @else
                &nbsp;
            @endif
            @if (config('app.dir') == 'ltr')
                @lang('language.list')
            @endif
        @endif
    </div>
    <div class="tools">
        {{-- <a href="javascript:;" class="collapse"></a> --}}
        {{-- <a href="#responsive" data-toggle="modal" class="config"></a> --}}
        {{-- <a href="javascript:;" class="remove"></a> --}}

        @if (@$toolbar['showTools'])
            <div class="btn-group">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" title="@lang('language.tools')">
                    <i class="fa fa-briefcase"></i>
                </a>
                <ul class="dropdown-menu @if(config('app.dir') == 'rtl') pull-left @else pull-right @endif">
                    <li>
                        <a href="#"> @lang('language.print')</a>
                    </li>
                    <li>
                        <a href="#"> @lang('language.save as pdf')</a>
                    </li>
                    <li>
                        <a href="#">  @lang('language.export to excel') </a>
                    </li>
                </ul>
            </div>
        @endif

        @if (!@$toolbar['hideLimit'])
            {{-- <a href="javascript:;" class="tooltips limit-icon" title="@lang('language.list limit')">
                <i class="fa fa-list-ol"></i>
            </a> --}}
            <input name="q[limit][count]" class="knob per-page display-none" data-angleoffset="-90" data-anglearc="180" data-fgcolor="#66EE66" value="{{ config('custom.perPage', 10) }}" data-height="17" data-width="45" data-displayInput="falss" data-options="{'min': 10, 'max': 200, 'step': 5, 'inputColor': '#fff'}" style="top: -1px;" data-release="App.list();" >
        @endif

        <a href="javascript:;" class="tooltips reload-icon reload" data-url="/{{ Request::path() }}" style="background: none;" 
            title="@lang('language.reload list')">
            <i class="fa fa-refresh"></i>
        </a>

        @if (@$tplsearch and !@$toolbar['hideSearch'])
            <a href="javascript:;" class="tooltips search-icon" title="@lang('language.search')">
                <i class="fa fa-search"></i>
            </a>
        @endif

        @if (!@$toolbar['hideCreate'])
            @var('id', config('app.id'))
            <a href="{{ Lib::getCurrentURL('controller') . '/create/' . $id }}" class="tooltips create-icon" data-toggle=""
                    title="@lang('language.add new')" 
                        onclick="App.call(this, {'method': 'create', 'id': '{{ config('app.id') }}', 'args': {'type': '{{@$type}}'}}, event);">
                 &nbsp;<i class="fa fa-plus"></i>
            </a>
        @endif

    </div>
</div>
