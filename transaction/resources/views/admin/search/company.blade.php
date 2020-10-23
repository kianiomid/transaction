<div class="row">
    {{-- Company title --}}
    <div class="form-group col-md-3">
        <input class="form-control placeholder-no-fix" type="text" name="q[where][name][like][str]" placeholder="@lang('language.name')" />
    </div>

    {{-- Status --}}
    <div class="form-group col-md-3">
        <div class="row">
            <label class="control-label col-md-2" style="margin-top: 5px;">
                {{ trans('language.status') }}:
            </label>
            <div class="col-md-10">    
                @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'search' => true, 'name' => 'q[where][status][eq][str]'])
            </div> 
        </div>       
    </div>    
</div>