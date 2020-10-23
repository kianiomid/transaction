@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
            <tr>
                <th>{!! trans('ajand.device') !!}</th>
                <th>{!! trans('language.user') !!}</th>
                <th>{!! trans('language.from') !!}</th>
                <th>{!! trans('language.to') !!}</th>
                <th colspan="3">{!! trans('language.status') !!}</th>
            </tr>
            @foreach(@$itemList as $key=>$val)
                <tr class="item-list">
                    <td>
                        {!! Form::hidden("frm[row$key][project_user_device_id]", @$val['xid'], array('class' => 'reset')) !!}
                        {!! Form::hidden("frm[row$key][project_id]", @$project['xid']) !!}
                        <select name="frm[row{{ $key  }}][device_id]" class="form-control reset" data-advancedselect="">
                            <option value="0">@lang('language.select') ...</option>
                            @foreach ($deviceList as $id=>$item)
                                <option value="{{ $item['device_id'] }}" @if(@ $val['device_id'] == $item['device_id']) selected="selected" @endif>{{$item['name'] .' '. $item['serial_number']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="frm[row{{ $key  }}][user_id]" class="form-control reset" data-advancedselect="">
                            <option value="0">@lang('language.select') ...</option>
                            @foreach ($userList as $id=>$item)
                                <option value="{{ $item['user_id'] }}" @if(@ $val['user_id'] == $item['user_id']) selected="selected" @endif>{{ $item['fname'] .' ' . $item['lname']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        {!! Form::text("frm[row$key][from_date]", @$val['from_date'] ? FarsiLib::g2jDate(@$val['from_date']) : FarsiLib::g2jDate(date('Y-m-d')), ['class' => 'form-control input-digit', 'data-datepicker']) !!}
                    </td>
                    <td>
                        {!! Form::text("frm[row$key][to_date]", @$val['to_date'] ? FarsiLib::g2jDate(@$val['to_date']) : FarsiLib::g2jDate(date('Y-m-d')), ['class' => 'form-control input-digit', 'data-datepicker']) !!}
                    </td>
                    <td>
                        @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'name' => "frm[row$key][status]", 'selected' => @$val['status']])
                    </td>
                    <td>
                        <a class="reset remBut" target="edit_frame" onclick="App.removeRow(this, 'item-list');"
                           href="{!! Lib::getCurrentURL('controller') . '/deleteUserDevice/' . @$val['project_user_device_id'] !!}">
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