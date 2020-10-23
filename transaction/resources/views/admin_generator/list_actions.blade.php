@foreach($generalActions as $action)
    <a
            class="{!! $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] !!}"
            style="margin-top: -10px; margin-bottom: 5px"
            href="{!! route($modelName.'.'.$action[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE]) !!}"
    >
        {{ __($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) }}
    </a>
@endforeach
@foreach($listActions as $action)
    <a
            class="{!! $action[\App\Http\Controllers\BGenerator\BaseController::NS_CLASS] !!}"
            style="margin-top: -10px; margin-bottom: 5px"
            href="{!! route($modelName.'.'.$action[\App\Http\Controllers\BGenerator\BaseController::NS_ROUTE]) !!}"
    >
        {{ __($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) }}
    </a>
@endforeach