@php
    $hasHelper = isset($hasHelper) ? $hasHelper : true;
@endphp
@php
    $label = $field[\App\Http\Controllers\BGenerator\WebController::NS_LABEL];
    $form = isset($field[$AGformType]) ? $field[$AGformType] : [];
    $class = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_CLASS]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_CLASS] : '';
    $formType = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_TYPE]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_TYPE] : 'text';
    $expanded = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_EXPANDED]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_EXPANDED] : false;
    $multiple = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_MULTIPLE]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_MULTIPLE] : false;
    $formChoices = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_CHOICES]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_CHOICES] : [];
    $helper = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_HELPER]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_HELPER] : '';
    $placeholder = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_PLACEHOLDER]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_PLACEHOLDER] : '';
    $mask = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_MASK]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_MASK] : null;
    $dataProvider = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_DATA_PROVIDER]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_DATA_PROVIDER] : null;

    $generalAttributes = [
        'class' => 'form-control ' . $class,
        'placeholder' => __($placeholder, [
            'name' => __($label)
        ])
    ];

    if(isset($formDefaults) && isset($formDefaults[$fieldName])){
        $defaultValue = $formDefaults[$fieldName];
    }else{
        if(isset($item)){
            $defaultValue = null;
        }else{
            $defaultValue = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_DEFAULT_VALUE]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_DEFAULT_VALUE] : null;
        }
    }

    if(!isset($input[$fieldName]) || $input[$fieldName] == null){
        $input[$fieldName] = "";
    }

@endphp
<div class="form-group col-sm-12 @if($errors->has($fieldName)) has-error @endif">
    {!! Form::label($fieldName, __($label) . ':', [
        'class' => $hasHelper ? 'col-sm-2 control-label' : 'col-sm-4 control-label'
    ]) !!}
    <div class="{{ $hasHelper ? "col-sm-5" : "col-sm-8" }}">
        @switch($formType)
            @case('text')
                {!! Form::text($fieldName, $errors->isEmpty() ? $defaultValue : $input[$fieldName] , $generalAttributes) !!}
                @break

            @case("textarea")
                @php
                    $generalAttributes['style'] = 'resize: vertical'
                @endphp
                {!! Form::textarea($fieldName, $errors->isEmpty() ? $defaultValue : $input[$fieldName], $generalAttributes) !!}
                @break

            @case("file")
                @break
            @case("hidden")
                {!! Form::hidden($fieldName, $errors->isEmpty() ? $defaultValue : $input[$fieldName]) !!}
                @break

            @case("password")
                @php $generalAttributes['autocomplete'] = 'off' @endphp
                {!! Form::password($fieldName, $generalAttributes) !!}
                @break

            @case("checkbox")
                <div style="margin-top: 5px">
                    {!! Form::hidden($fieldName, 0) !!}
                    {!! Form::checkbox($fieldName, 1, $errors->isEmpty() ? $defaultValue : $input[$fieldName], ['class' => 'square', 'id' => $fieldName . '_chk']); !!}
                </div>
                @break
            @case("select")
                @if($expanded == true)
                    @php $radioClass = sizeof($formChoices) >= 5 ? 'radio' : 'radio-inline' @endphp
                    @foreach($formChoices as $formChoiceKey => $formChoiceValue)
                        <div class="{{ $radioClass }}">
                            <label>
                                {{ Form::radio($fieldName, $formChoiceKey, $errors->isEmpty() ? $defaultValue == $formChoiceKey : (isset($input[$fieldName]) && $input[$fieldName] == $formChoiceKey) , ['class' => 'flat-blue']) }}
                                {!! $formChoiceValue !!}
                            </label>
                        </div>
                    @endforeach
                @else
                    @if($multiple == true)
                        @section("scripts")
                            @parent
                            <script>$("#{!! $fieldName !!}").select2()</script>
                        @endsection
                        {!! Form::select($fieldName, $formChoices, $errors->isEmpty() ? $defaultValue : $input[$fieldName], [
                            'class' => 'form-control ' . $class,
                            'name'  =>  $fieldName . "[]",
                            "multiple" => "multiple",
                            "data-placeholder" => __($placeholder)
                        ]) !!}
                    @else
                        @include('admin_generator.field_select')
                    @endif

                @endif

                @break

            @case("autocomplete")

                @include('admin_generator.field_autocomplete')
                @break

            @case("date")

                @include("admin_generator.datepicker_persian", [
                    'defaultValue' => $errors->isEmpty() ? $defaultValue : $input[$fieldName]
                ])
                @section("scripts")
                    @parent
                    <script>
                    $(document).ready(function () {
                        initDatePicker('{{ $fieldName }}');
                    });
                    </script>
                @endsection

                @break
            @case("date_range")
                @break
            @case("datetime")
                @include("admin_generator.datepicker_persian", [
                    'defaultValue' => $errors->isEmpty() ? $defaultValue : $input[$fieldName]
                ])
                @section("scripts")
                    @parent
                    <script>
                    $(document).ready(function () {
                        initDateTimePicker('{{ $fieldName }}');
                    });
                    </script>
                @endsection

                @break
            @case("datetime_range")
                @break
        @endswitch
    </div>
    @if($hasHelper)
    <div class="col-sm-5">
        <span class="help-block">

            @if($errors->has($fieldName))
                @foreach ($errors->get($fieldName) as $message)
                    <p>
                        <i class="fa fa-times-circle-o"></i>
                        {{ $message }}
                    </p>
                @endforeach
            @else
                {!! $helper !!}
            @endif

        </span>
    </div>
    @endif

    @if($mask != null)
        @section("scripts")
            @parent
            <script>
                $("#{{ $fieldName }}").inputmask("{{ $mask }}")
            </script>
        @endsection
    @endif

</div>