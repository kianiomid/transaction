{{-- First name --}}
<div class="form-group">
    <label class="control-label col-md-2">
       @lang('language.first name'):
        <span class="required">*</span>
    </label>
    <div class="col-md-10">
        <input type="hidden" name="frm[user_info][user_id]" value="{{ @$list['user_id'] }}">
        <input type="text" name="frm[user_info][fname]" value="{{ @$list['fname'] }}" class="form-control" autocomplete="off" required="required" title="{{ t('language.this field is required') }}">
        <span class="help-block">@lang("language.like"): @lang('language.john')</span>
    </div>
    <div class="clearfix"></div>
</div>

 {{--Last name --}}
<div class="form-group">
    <label class="control-label col-md-2">
       @lang('language.last name'):
        <span class="required">*</span>
    </label>
    <div class="col-md-10">
        <input type="text" name="frm[user_info][lname]" value="{{ @$list['lname'] }}" class="form-control" autocomplete="off" required="required" title="{{ t('language.this field is required') }}">
        <span class="help-block">@lang("language.like"): @lang('language.smith')</span>
    </div>
    <div class="clearfix"></div>
</div>

{{-- License --}}
<div class="form-group">
    <label class="control-label col-md-2">
        @lang('ajand.license'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
        <div class="col-md-6">
            <select name="license" class="form-control license-select"  data-selected="{{ @$list['license_item_id'] }}"
                    onchange="App.setSubGroup(itemList, 0, $(this), $('select.item-select'));" >
                @foreach (@$licenseCombo as $key=>$item)
                    <option value="{{ $key }}" @if(@$list['license_id'] == $key) selected @endif>{{ $item }}</option>
                @endforeach
            </select>
         </div>
        <div class="col-md-6">
            <select class="col-md-4 item-select form-control" name="frm[user][license_item_id]"></select>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
{{-- Email --}}
<div class="form-group">
    <label class="control-label col-md-2">
       @lang('language.email'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="email" name="frm[user][email]" value="{{ @$list['email'] }}" class="form-control ltr" autocomplete="off">
        </div>
    </div>
    <div class="clearfix"></div>
</div>

{{-- Gender --}}
<div class="form-group">
    <label class="control-label col-md-2">
       @lang('language.gender'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
        @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$genderList, 'name' => 'frm[user_info][gender]', 'selected' => @$list['gender']])
    </div>
    <div class="clearfix"></div>
</div>
{{-- force logout --}}
<div class="form-group">
    <label class="control-label col-md-2">
       @lang('language.force logout'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
        {!! Form::checkbox('frm[user][force_logout]', 1, @$list['force_logout'], ['class' => 'form-control']) !!}
    </div>
    <div class="clearfix"></div>
</div>

{{-- Mobile --}}
<div class="form-group">
    <label class="control-label col-md-2">
    @lang('language.mobile'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
    <div class="input-icon">
        <i class="fa fa-mobile"></i>
        <input type="tel" name="frm[user_info][mobile]" value="{{ @$list['mobile'] }}" class="form-control ltr" autocomplete="off">
    </div>
    </div>
    <div class="clearfix"></div>
</div>

{{-- Phone --}}
<div class="form-group">
    <label class="control-label col-md-2">
    @lang('language.phone'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
    <div class="input-icon">
        <i class="fa fa-phone"></i>
        <input type="tel" name="frm[user_info][tel]" value="{{ @$list['tel'] }}" class="form-control ltr" autocomplete="off">
    </div>
    </div>
    <div class="clearfix"></div>
</div>

{{-- Fax --}}
<div class="form-group">
    <label class="control-label col-md-2">
    @lang('language.fax'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
    <div class="input-icon">
        <i class="fa fa-fax"></i>
        <input type="tel" name="frm[user_info][fax]" value="{{ @$list['fax'] }}" class="form-control ltr" autocomplete="off">
    </div>
    </div>
    <div class="clearfix"></div>
</div>

{{-- Address --}}
<div class="form-group">
    <label class="control-label col-md-2">
    @lang('language.address'):
    </label>
    <div class="col-md-10" style="margin-bottom: 15px;">
    <textarea name="frm[user_info][address]" rows="2" style="width: 100%;"></textarea>
    </div>
    <div class="clearfix"></div>
</div>

@if (@$groupList)
    {{-- User Groups --}}
    <div class="form-group">
        <label class="control-label col-md-2">
           @lang('language.group'):
        </label>
        <div class="col-md-10" style="margin-bottom: 15px;">
            <select name="group[]" class="form-group" multiple="multiple">
                @foreach ($groupList as $key => $val)
                    <option value="{{ $val['role_id'] }}" {{ array_key_exists(@$val['role_id'], @$list['groupList'] ?: []) ? 'selected="selected"' : '' }}>
                        @lang('language.' . $val['title'])
                    </option>
                @endforeach
            </select>
        </div>
        <div class="clearfix"></div>
    </div>
@endif

@if (config('app.action') != 'profile')
    @if (@$statusList)
        {{-- Status --}}
        <div class="form-group">
            <label class="control-label col-md-2">
               @lang('language.status'):
            </label>
            <div class="col-md-10" style="margin-bottom: 15px;">
                @include('backend.partial.radioBox', ['lang' => 'language', 'list' => @$statusList, 'name' => 'frm[user][user_status]', 'selected' => @$list['user_status']])
            </div>
            <div class="clearfix"></div>
        </div>
    @endif
@endif

<script type="text/javascript">
    itemList = {!! @$itemComboList ? $itemComboList : '[]' !!};
    App.setSubGroup(itemList, 0, $('select.license-select'), $('select.item-select'));


    if (typeof Custom != 'undefined') {
        Custom.multiSelect($('select[multiple]'));
    }
</script>