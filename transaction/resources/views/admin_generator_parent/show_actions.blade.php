@php $submitFound = false; @endphp
@foreach($actions as $action)
    @if($action[\App\Http\Controllers\BGenerator\BaseController::NS_TYPE] == \App\Http\Controllers\BGenerator\BaseController::BUTTON_TYPE_SUBMIT)
        @php $submitFound = true; @endphp
        {!! Form::open(['route' => [$modelName.'.' . $action[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE], $item->id], 'method' => $action[\App\Http\Controllers\BGenerator\BaseController::NS_METHOD]]) !!}
        @break
    @endif
@endforeach

@foreach($actions as $actionKey => $action)

    @if($action[\App\Http\Controllers\BGenerator\BaseController::NS_TYPE] == \App\Http\Controllers\BGenerator\BaseController::BUTTON_TYPE_SUBMIT)

        @php
        $buttonArray = [
            'type' => 'submit',
            'class' => isset($action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS]) ? $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] : 'btn btn-'.$fieldSetClass
        ];
        if(isset($action[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM])){
            $buttonArray['onclick'] = 'return confirm("' . __($action[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM]) . '");' ;
        }
        @endphp
        {!! Form::button(__($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]), $buttonArray) !!}
    @else

        @if($actionKey == "list")
            @php $routeParams['pid'] = $parentObject->$parentRelatedKey @endphp
        @else
            @php $routeParams[] = $item->id @endphp
        @endif

        <a
                href="{!! route($modelName . '.' . $action[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE] , $routeParams) !!}"
                class="{{ $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] }}"
                title=""
        >
            {!! __($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) !!}
        </a>
    @endif
@endforeach



@if($submitFound)
    {!! Form::close() !!}
@endif
