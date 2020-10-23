@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
            <tr>
                <th>{!! trans('language.title') !!}</th>
                <th colspan="3">{!! trans('language.display rank') !!}</th>
            </tr>
            @foreach(@$list as $key=>$val)
                <tr class="item-list">
                    <td>
                        {!! Form::hidden("frm[row$key][fieldset_id]", @$val['xid'], array('class' => 'reset')) !!}
                        {!! Form::hidden("frm[row$key][application_id]", @$application['xid']) !!}
                        {!! Form::text("frm[row$key][title]", e(@$val['title']), array('class' => 'form-control')) !!}
                    </td>
                    <td>
                        {!! Form::text("frm[row$key][rank]", e(@$val['rank']), array('class' => 'form-control input-digit', 'style' => 'width:50px;')) !!}
                    </td>
                    <td>
                        @if(Config::get('app.section') == 'Admin')
                            <a class="reset remBut" target="edit_frame" onclick="App.removeRow(this, 'item-list');"
                               href="{!! Lib::getCurrentURL('controller') . '/deleteFieldset/' . @$val['xid'] !!}">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
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