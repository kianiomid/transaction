@csrf
<div class="box-body">
    @foreach($filterItems as $formItem)

        @php $rawformItem = $formItem; @endphp
        @if(substr($formItem, 0, 1) == '_')
            @php $rawformItem = substr($formItem, 1); @endphp
        @endif

        @foreach($fields as $f_k => $f_v)

            @if($f_k == $rawformItem)

                    @if(substr($formItem, 0, 1) == '_')
                        @include($customView . ".filter" . $headerItem , [
                            'fieldName' => $f_k,
                            'field'     => $f_v,
                            'formItem'  => $formItem,
                            'AGformType'  => \App\Http\Controllers\BGenerator\BaseController::NS_FILTER,
                        ])
                    @else
                        @include('admin_generator.field' , [
                            'fieldName' => $f_k,
                            'field'     =>  $f_v,
                            'formItem'  => $formItem,
                            'AGformType'  => \App\Http\Controllers\BGenerator\BaseController::NS_FILTER,
                            'hasHelper'     => false
                        ])
                    @endif

            @endif

        @endforeach

    @endforeach
</div>

@section("scripts")
    @parent
    @include("admin_generator.icheck_scripts")
    @include("admin_generator.datepicker_scripts")
@endsection