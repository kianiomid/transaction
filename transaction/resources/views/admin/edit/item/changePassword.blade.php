@section('content')
    <div class="col-md-12 col-xs-12 table-responsive">
        <div class="form-group">
            <div class="input-icon">
                <i class='fa fa-lock'></i>
                {!! Form::password('frm[newpassword]', array('class' => 'form-control ltr', 'autocomplete' => 'off', 'id' => 'new-password', 'placeholder' => trans('language.new password')))  !!}
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon">
                <i class='fa fa-lock'></i>
                {!! Form::password('frm[retypepassword]', array('class' => 'form-control ltr', 'autocomplete' => 'off', 'placeholder' => trans('language.re-type new password')))  !!}
            </div>
        </div>
        <div class="form-group">
            <div class="input-icon">
                @lang('language.reset in first login')
                {!! Form::checkbox('frm[reset_password]', 1, @$list['reset_password'], ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
@stop