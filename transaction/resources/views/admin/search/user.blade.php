<div class="row">
    {{-- Username --}}
    <div class="form-group col-md-3">
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="q[where][username][like][str]" class="form-control placeholder-no-fix ltr" placeholder="@lang('language.username')" />
        </div>
    </div>
    
    {{-- First name --}}           
    <div class="form-group col-md-3">
        <input type="text" name="q[where][fname][like][str]" class="form-control placeholder-no-fix" placeholder="@lang('language.first name')" />
    </div>  

    {{-- Last name --}}  
    <div class="form-group col-md-3">
        <input type="text" name="q[where][lname][like][str]" class="form-control placeholder-no-fix" placeholder="@lang('language.last name')" />
    </div>    
    
    {{-- Email --}}           
    <div class="form-group col-md-3">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="text" name="q[where][email][like][str]" class="form-control placeholder-no-fix ltr" placeholder="@lang('language.email')" />
        </div>
    </div>
    <div class="clearfix"></div>
    
    {{-- Mobile --}}
    <div class="form-group col-md-3">
        <div class="input-icon">
            <i class="fa fa-mobile"></i>
            <input type="tel" name="q[where][mobile][like][str]" class="form-control placeholder-no-fix ltr" placeholder="@lang('language.mobile')" />
        </div>
    </div>

    {{-- Phone --}}
    <div class="form-group col-md-3">
        <div class="input-icon">
            <i class="fa fa-phone"></i>
            <input type="tel" name="q[where][tel][like][str]" class="form-control placeholder-no-fix ltr" placeholder="@lang('language.phone')" />
        </div>
    </div>

    {{-- Fax --}}
    <div class="form-group col-md-3">
        <div class="input-icon">
            <i class="fa fa-fax"></i>
            <input type="tel" name="q[where][fax][like][str]" class="form-control placeholder-no-fix ltr" placeholder="@lang('language.fax')" />
        </div>
    </div>

    {{-- Group --}}
    {{--<div class="form-group col-md-3">--}}
        {{--@if(@$groupList)--}}
            {{--<select name="q[where][r.role_id][eq][int]" class="form-control" data-advancedselect="">--}}
                {{--<option value="">@lang('language.select')  @lang('language.group')...</option>--}}
                {{--@foreach ($groupList as $groupid => $rolep)--}}
                    {{--<option value="{{ $rolep['role_id'] }}">@lang('language.' . $rolep['title'])</option>--}}
                {{--@endforeach --}}
            {{--</select>--}}
        {{--@endif--}}
    {{--</div>   --}}
    {{--<div class="clearfix"></div>--}}

    {{-- Gender --}}
    <div class="form-group col-md-3"> 
        <div class="row">
            <label class="control-label col-md-2" style="margin-top: 5px;">
                @lang('language.gender'):
            </label>
            <div class="col-md-10">
                @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$genderList, 'search' => true, 'name' => 'q[where][gender][eq][str]'])
            </div>
        </div> 
    </div>  

    {{-- Status --}}
    <div class="form-group col-md-3"> 
        <div class="row">
            <label class="control-label col-md-2" style="margin-top: 5px;">
                @lang('language.status'):
            </label>
            <div class="col-md-10">
                @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'search' => true, 'name' => 'q[where][user_status][eq][str]'])
            </div>
        </div> 
    </div>  
</div>    
<script type="text/javascript" src="{{ asset('/assets/plugins/bootstrap-multiselect-master/dist/js/bootstrap-multiselect.js') }}"></script>
<script type="text/javascript">
    $(window).load(function() {
        Custom.multiSelect($('select[multiple]'));      
    });
</script>