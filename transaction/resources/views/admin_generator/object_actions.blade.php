@php $submitFound = false; @endphp
@foreach($objectActions as $objectAction)
    @if($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_TYPE] == \App\Http\Controllers\BGenerator\BaseController::BUTTON_TYPE_SUBMIT)
        @php $submitFound = true; @endphp
        {!! Form::open(['route' => [$modelName.'.' . $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE], $item->id], 'method' => $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_METHOD]]) !!}
        @break
    @endif
@endforeach

<div class='btn-group'>

    @foreach($objectActions as $objectAction)

        @if($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_TYPE] == \App\Http\Controllers\BGenerator\BaseController::BUTTON_TYPE_SUBMIT)

            @php
            $buttonArray = [
                'type' => 'submit',
                'class' => $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS],
                'title' => __($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL])
            ];
            if(isset($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM])){
                $buttonArray['onclick'] = 'return confirm("' . __($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_CONFIRM]) . '");' ;
            }
            @endphp
            {!! Form::button('<i class="'.$objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_ICON].'"></i>', $buttonArray) !!}
        @else
            <a
                    href="{!! route($modelName . '.' . $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE] , [$item->id]) !!}"
                    class="{{ $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] }}"
                    title="{{ __($objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) }}"
            >
                        <i class="{{ $objectAction[\App\Http\Controllers\BGenerator\BaseController::NS_ICON] }}"></i>
            </a>
        @endif
    @endforeach

</div>

@if($submitFound)
    {!! Form::close() !!}
@endif
