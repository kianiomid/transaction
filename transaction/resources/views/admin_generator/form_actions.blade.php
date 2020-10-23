@foreach($actions as $actionKey => $action)

    @if($action[\App\Http\Controllers\BGenerator\BaseController::NS_TYPE] == \App\Http\Controllers\BGenerator\BaseController::BUTTON_TYPE_SUBMIT)

        @php
        $buttonArray = [
            'name' => $actionKey,
            'class' => isset($action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS]) ? $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] : 'btn btn-'.$fieldSetClass
        ];
        if(isset($action[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM])){
            $buttonArray['onclick'] = 'return confirm("' . __($action[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM]) . '");' ;
        }
        @endphp

        {!! Form::submit(__($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]), $buttonArray) !!}

    @else
        @php $routeParams = [] @endphp
        @if($item != null && $actionKey != "list")
            @php $routeParams[] = $item->id @endphp
        @endif
        <a
                href="{!! route($modelName.'.' . $action[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE], $routeParams) !!}"
                class="{!! $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] !!}"
        >{{ __($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) }}
        </a>
    @endif

@endforeach