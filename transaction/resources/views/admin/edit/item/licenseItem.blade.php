@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
            <tr>
                <th>{!! trans('language.type') !!}</th>
                <th>{!! trans('language.count') !!}</th>
                <th>{!! trans('language.display rank') !!}</th>
                <th colspan="3">{!! trans('language.status') !!}</th>
            </tr>
            @foreach(@$itemList as $key=>$val)
                <tr class="item-list">
                    <td>
                        {!! Form::hidden("frm[row$key][license_item_id]", @$val['xid'], array('class' => 'reset')) !!}
                        {!! Form::hidden("frm[row$key][license_id]", @$license['xid']) !!}
                        <select name="frm[row{{ $key  }}][license_type_id]" class="form-control" data-advancedselect="">
                            <option value="0">@lang('language.select') ...</option>
                            @foreach ($typeList as $id=>$item)
                                <option value="{{ $id }}" @if(@$val['license_type_id'] && $val['license_type_id'] == $id) selected="selected" @endif>{{ $typeList[$id] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        {!! Form::text("frm[row$key][count]", e(@$val['count']), array('class' => 'form-control')) !!}
                    </td>
                    <td>
                        {!! Form::text("frm[row$key][rank]", e(@$val['rank']), array('class' => 'form-control input-digit', 'style' => 'width:50px;')) !!}
                    </td>
                    <td>
                        @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'name' => "frm[row$key][status]", 'selected' => @$val['status']])
                    </td>
                    <td>
                        <a class="reset remBut" target="edit_frame" onclick="App.removeRow(this, 'item-list');"
                           href="{!! Lib::getCurrentURL('controller') . '/deleteItem/' . @$val['license_item_id'] !!}">
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