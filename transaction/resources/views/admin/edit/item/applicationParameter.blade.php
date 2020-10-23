@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
                <tr>
                    <th>{!! trans('ajand.parameter') !!}</th>
                    <th>{!! trans('ajand.level') !!}</th>
                    <th>{!! trans('ajand.fieldset') !!}</th>
                    <th>{!! trans('ajand.descriptor') !!}</th>
                    <th>{!! trans('language.display rank') !!}</th>
                    <th colspan="3"></th>
                </tr>
                @foreach(@$itemList as $key=>$val)
                    <tr class="item-list">
                        <td>
                            {!! Form::hidden("param[row$key][application_parameter_id]", @$val['xid'], ['class' => 'reset']) !!}
                            {!! Form::hidden("param[row$key][application_id]", @$application['xid']) !!}
                            <select name="param[row{{ $key }}][parameter_id]" class="form-control" data-advancedselect=""   style="width: 200px !important;" >
                                <option value="0">@lang('language.select') ...</option>
                                @foreach ($parameterList as $id=>$item)
                                    <option value="{{ $id }}" @if(@$val['parameter_id'] && $val['parameter_id'] == $id) selected="selected" @endif>{{ $parameterList[$id] }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="param[row{{ $key }}][level]" class="form-control" data-advancedselect="">
                                <option value="0">@lang('language.select') ...</option>
                                @foreach ($levelList as $id=>$item)
                                    <option value="{{ $item }}" @if($val['level'] == $item) selected="selected" @endif>@lang('ajand.'.$item)</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="param[row{{ $key }}][fieldset_id]" class="form-control" data-advancedselect="">
                                <option value="0">@lang('language.select') ...</option>
                                @foreach ($fieldSet as $id=>$item)
                                    <option value="{{ $id }}" @if($val['fieldset_id'] == $id) selected="selected" @endif>{{ $item  }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {!! Form::text("param[row$key][descriptor]", @$val['descriptor'], array('class' => 'form-control input-small')) !!}
                        </td>
                        <td>
                            {!! Form::text("param[row$key][rank]", @$val['rank'], array('class' => 'form-control input-small')) !!}
                        </td>
                        <td>
                            <a class="reset remBut" target="edit_frame" onclick="App.removeRow(this, 'item-list');"
                               href="{!! Lib::getCurrentURL('controller') . '/deleteParameter/' . @$val['application_parameter_id'] !!}">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a class="addBut" onclick="var newObj = App.duplicateRow('item-list');" href="javascript:void(0)">
                                <i class="fa fa-plus-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
    </div>
    <script>
        App.normalizeRows('item-list');
    </script>
@stop