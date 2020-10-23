<div class="input-group date">
    <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
    </div>
    {!! Form::hidden($fieldName, $errors->isEmpty() ? $defaultValue : $input[$fieldName]) !!}

    @if(\Illuminate\Support\Facades\App::getLocale() == "fa")
        @php $generalAttributes['id'] = $fieldName."__alt" @endphp
    @else
        @php $generalAttributes['id'] = $fieldName."__alt" @endphp
    @endif

{{--    @php $generalAttributes['id'] = $fieldName."__alt" @endphp--}}
    @php $generalAttributes['autocomplete'] = "off" @endphp

    @if(\Illuminate\Support\Facades\App::getLocale() == "fa")
        {!! Form::text($fieldName."__alt", null, $generalAttributes) !!}

    @else
        {!! Form::text($fieldName."__alt", null, $generalAttributes) !!}
    @endif
    <span class="fa fa-close input-btn-reset" onclick="resetDatePicker('{{ $fieldName }}');"></span>
</div>
