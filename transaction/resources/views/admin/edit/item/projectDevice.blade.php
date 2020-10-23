@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
            <tr>
                <th>{!! trans('ajand.device') !!}</th>
                <th colspan="3">{!! trans('language.status') !!}</th>
            </tr>
            @foreach(@$list as $key=>$val)
                <tr class="item-list">
                    <td>
                        {!! Form::hidden("frm[row$key][project_device_id]", @$val['xid'], array('class' => 'reset')) !!}
                        {!! Form::hidden("frm[row$key][project_id]", @$project['xid']) !!}
                        <select name="frm[row{{ $key  }}][device_id]" class="form-control" data-advancedselect="">
                            <option value="0">@lang('language.select') ...</option>
                            @foreach ($deviceList as $id=>$item)
                                <option value="{{ $item['id'] }}" @if(@ $val['device_id'] == $item['id']) selected="selected" @endif>{{$item['bname'] .' '. $item['serial_number']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'name' => "frm[row$key][status]", 'selected' => @$val['status']])
                    </td>
                    <td>
                        <a class="reset remBut" target="edit_frame" onclick="App.removeRow(this, 'item-list');"
                           href="{!! Lib::getCurrentURL('controller') . '/deleteDevice/' . @$val['project_device_id'] !!}">
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