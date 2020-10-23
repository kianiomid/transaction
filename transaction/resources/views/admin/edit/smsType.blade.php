@section('content')
    <div class="col-xs-12">    
        {{-- license type title --}}
        <div class="form-group">
            <label class="control-label col-md-2">
                @lang('language.name'):
                <span class="required">*</span>
            </label>
            <div class="col-md-10">
                <input type="text" name="frm[name]" value="{{ @$list['name'] }}" class="form-control" autocomplete="off" required="required" title="@lang('language.please enter title')">
                <span class="help-block">@lang('language.name'): Google</span>
            </div>
            <div class="clearfix"></div>
        </div>
         {{--rank--}}
        <div class="form-group">
            <label class="control-label col-md-2">
                @lang('language.descriptor'):
            </label>
            <div class="col-md-10">
                <input type="text" name="frm[descriptor]" value="{{ @$list['descriptor'] }}" class="form-control" autocomplete="off">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">
                @lang('language.sample'):
            </label>
            <div class="col-md-10">
                <input type="text" name="frm[sample]" value="{{ @$list['sample'] }}" class="form-control" autocomplete="off">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@stop