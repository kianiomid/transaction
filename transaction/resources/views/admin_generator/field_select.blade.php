{!! Form::select($fieldName, $formChoices, $errors->isEmpty() ? $defaultValue : $input[$fieldName], [
    'class' => 'form-control ' . $class
]) !!}