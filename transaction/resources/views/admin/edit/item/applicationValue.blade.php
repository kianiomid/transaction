@section('content')
    <div class="row table-border" style="padding: 15px">
        <div class="form-group " style="">
            <div class="col-md-2" >@lang('ajand.creation date') : </div>
            <div class="col-md-2" style="direction: ltr">{!! FarsiLib::g2jdate($list['created_at']) !!}</div>
        </div>
        @var('cnt', 0)
        @foreach($parameter as $paramkey => $param)
            @var('type', $param['type'])
            @var('vtype', $param['validation']['type'])
            @if($cnt >1)
                <div class="clearfix" style="border-bottom:solid 1px #eee; margin-bottom:15px"></div>
                @var('cnt', 0)
            @else
                @var('cnt', $cnt+1)
            @endif
            @if(in_array($type,['checkbox', 'radio']))
                <div class="clearfix" style="border-bottom:solid 1px #eee; margin-bottom:15px"></div>
                @var('cnt', 2)
                <div class="form-group">
                    <label class="col-md-2">{{ $param['label'] }}</label>
                    <div class="col-md-10">
                        @var('internal', 0)
                        @foreach(@$param['opt'] as $key=>$opt)
                            @if($internal >1)
                                <div class="clearfix" style="border-bottom:solid 1px #eee; margin-bottom:15px"></div>
                                @var('internal', 0)
                            @else
                                @var('internal', $internal+1)
                            @endif
                            <div  class="col-md-4">
                                <label class="col-md-6">{{ $opt }}</label>
                                <input class="col-md-6 toggle" type="{{ $type  }}" name="@if($type == 'radio')frm[{{ $param['ap_id'] }}]@else frm[{{$param['ap_id'].'.'.$key}}] @endif" value="{{ $key }}" @if(in_array($key, @$param['value'])) checked="checked"@endif @if(@$report) disabled="disabled" @endif/>
                            </div>
                        @endforeach
                    </div>

                </div>
            @elseif($type == 'textarea')
                @var('cnt', 0)
                <div class="clearfix" style="border-bottom:solid 1px #eee; margin-bottom:15px"></div>
                <div class="form-group">
                    <label class="col-md-3">{{ $param['label'] }}</label>
                    <textarea class="col-md-9 input-medium" name="frm[{{ $param['ap_id'] }}]" @if(@$report) readonly="readonly" @endif>{{ @$param['value'][0] }}</textarea>
                </div>
                <div class="clearfix" style="border-bottom:solid 1px #eee; margin-bottom:15px"></div>
            @else
                <div class="form-group col-md-6">
                    <label class="col-md-4">{{ $param['label'] }}</label>
                    @if(in_array($type,['password', 'text']))
                        <input class="form-control col-md-8 input-small" type="{{ $type }}" value="@if(in_array($vtype,['date', 'datetime'])) {{ FarsiLib::g2jdate(@$param['value'][0]) }} @else{{ @$param['value'][0] }} @endif" name="frm[{{ $param['ap_id'] }}]" @if(in_array($vtype,['date', 'datetime', 'time'])) data-datepicker = "data-datepicker" @endif  @if(@$report) readonly="readonly" @endif/>
                    @elseif($type == 'select')
                        <select class="form-control col-md-8" name="frm[{{ $opt['ap_id'] }}]"  @if(@$report) disabled="disabled" @endif>
                            @foreach(@$param['opt'] as $key=>$opt)
                                <option value="{{ $key }}" @if( $opt == @$param['value'][0]) selected="selected" @endif>{{ $opt }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@stop