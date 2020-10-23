@section('content')
    <div class="col-md-12">
        {{-- Username --}}
        <div class="form-group">
            <label class="control-label col-md-2">
               @lang('language.username'):
                <span class="required">*</span>
            </label>
            <div class="col-md-10" style="margin-bottom: 15px;">
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input type="text" name="frm[user][username]" value="{{ @$list['username'] }}" class="form-control ltr" autocomplete="off" required="required" title="{{ t('language.username is required') }}">
                </div>    
            </div>
        </div>

        {{-- Password --}}
        @if(!@$list)
            <div class="form-group">
                <label class="control-label col-md-2">
                    @lang('language.password'):
                </label>
                <div class="col-md-10" style="margin-bottom: 15px;">
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="frm[user][password]" value="{{ @$list['password'] }}" class="form-control ltr" autocomplete="off">
                    </div>
                </div>
            </div>
        @endif
        @include('admin.edit.partial.userInfo')
        @include('admin.edit.partial.userImage')
    </div>
@stop