@section('content')
    @if ($list->total() > 0)
        <div>
            <div class="label label-info pull-right" style="font-size: 10px;">
                {{ ($list->perPage() * $list->currentPage()) > $list->total() ? $list->total() . ' ' . trans('language.from') . ' ' . $list->total() : (($list->perPage() * $list->currentPage()) . ' ' . trans('language.from') . ' ' . $list->total())  }}
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                @if (@$listBtn['showCheckbox'])
                    <th style="width: 0.05%" class="table-checkbox">
                        {!! Form::checkbox('checkall', 0, 0, array('class' => 'check-all')) !!}
                    </th>
                @endif
                @if (@$expand)
                    <th style="width: 0.05%">&nbsp;</th>
                @endif
                @if (@$field)
                    <th class="text-center rotate90" scope="col" style="padding: 8px 0;width: 0.5%;">
                        <span>@lang('language.tier')</span>
                    </th>
                    @foreach (@$field as $fldkey => $fld)
                        <th scope="col" style="{{ @$fld['css'] }}" class="sortable {{ @$fld['sortable'] ? 'sorting' : '' }}" @if(@$fld['sortable']) onclick="App.sortList(this)" data-fld="{{ @$fld['sortable'] }}" @endif>
                            {!! @$fld['name'] !!}
                        </th>
                    @endforeach
                    @if (!@$hidelistbtn)
                        <th style="width: 0.1%;">&nbsp;</th>
                    @endif
                @endif
            </tr>
        </thead>
        <tbody>
            @php($cnt = (@$list->currentPage() - 1) * @$list->perPage())

            @if (@$list)
                @foreach (@$list as $listkey => $item)
                    <tr class="odd gradeX {{ @$item['class'] }}">
                        @if (@$expand)
                            <td style="vertical-align: middle;">
                                @if (@$item['expandList'])
                                <a href="javascript:void(0)" class="list-btn-expand">
                                    <i class="fa fa-plus-square-o" style="cursor: pointer;"></i>
                                </a>
                                @else
                                    <i class="fa fa-plus-square-o" style="color: #ccc;"></i>
                                @endif
                            </td>
                        @endif
                        @if (@$listBtn['showCheckbox'])
                            <td style="vertical-align: middle;">
                                {!! Form::checkbox('listchk[]', 0, 0, array('class' => 'checkboxes')) !!}
                            </td>
                        @endif
                        <td class="text-center mitra" style="vertical-align: middle;font-weight: bold;">
{{--                            {{ ++$cnt }}--}}
                        </td>
                        @foreach(@$field as $i)
                            <td style="vertical-align: middle;">
                                @if (@$i['php'])
                                    @eval(@$i['php'])
                                @endif

                                @if (@$i['include'])
                                    @include($i['include'])
                                @endif
                            </td>
                        @endforeach
                        @if (!@$hidelistbtn)
                            <td style="vertical-align: middle;">@include('backend.listBtn')</td>
                        @endif
                    </tr>
                    @if (@$expand and @$item['expandList'])
                        <tr class="row-expand display-none">
                            <td colspan="{{ count(@$field) + 3 }}">
                                <div class="table-responsive display-none">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center rotate90" scope="col" style="padding: 8px 0;width: 0.5%;">
                                                    <span>@lang('language.tier')</span>
                                                </th>
                                                @foreach ($expand as $exKey => $ex)
                                                    <th scope="col"
                                                        @if (@$ex['options'])
                                                            @foreach($ex['options'] as $ko => $o)
                                                                {{ $ko }}="{{ $o }}"
                                                            @endforeach
                                                        @endif>
                                                        {!! @$ex['name'] !!}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @var('cntEx', 1)
                                            @foreach ($item['expandList'] as $lke => $exItem)
                                                <tr>
                                                    <td class="text-center">{{ $cntEx }}</td>
                                                    @foreach(@$expand as $exp)
                                                        <td style="vertical-align: middle;">
                                                            @if (@$exp['php'])
                                                                @eval(@$exp['php'])
                                                            @endif

                                                            @if (@$exp['include'])
                                                                @include($exp['include'])
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                                @var('cntEx', ++$cntEx)
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if (!@$list)
                <tr class="odd gradeX">
                    <td colspan="{{ count(@$field) }}">
                        <div style="padding: 30px; text-align: center;">@lang('language.no record found.')</div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div>
        @if ($list->total() > 0)
            <div class="label label-info pull-right" style="font-size: 10px;">
                {{ ($list->perPage() * $list->currentPage()) > $list->total() ? $list->total() . ' ' . trans('language.from') . ' ' . $list->total() : (($list->perPage() * $list->currentPage()) . ' ' . trans('language.from') . ' ' . $list->total())  }}
            </div>
        @endif
        @if (env('APP_ENV') == 'local' || Input::get('showTime', 0))
            <div class="label label-info load-time pull-left ltr" style="font-size: 10px;">
                {{ @$loadTime }} sec
            </div>
        @endif
        <div class="clearfix"></div>
    </div>

    @if (@$list and @!$hidePagination)
        <div class="text-center">
            {!!  $list->render() !!}
        </div>
    @endif
    <script>
        $(window).off('load').load(function() {
            var id = "{{ config('app.id') }}";
            if (id && window.location.href.match(/popup=\d+/i) != null) {
                App.call($('.data-list'), {'url': "{{ Lib::getCurrentURL('controller') }}/edit/" + id, 'method': 'edit', 'id': id});
            }
        });
    </script>
@show