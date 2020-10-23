@php $multipleFieldSets = sizeof($formFieldSets) > 1; @endphp
@php $fieldSetIndex = 0; $lastFieldSet = false; @endphp

@foreach($formFieldSets as $formFieldName => $formFieldSet)

    @php
        $fieldSetIndex++ ;
        $lastFieldSet = $fieldSetIndex == sizeof($formFieldSets)
    @endphp

    @php
        $fieldSetClass = "primary";
        foreach($fieldSetsSkeleton as $fsSkeletonKey => $fsSkeletonValue){
            if($fsSkeletonKey == $formFieldName){
                if(isset($fsSkeletonValue[\App\Http\Controllers\BGenerator\WebController::NS_CLASS])){
                    $fieldSetClass = $fsSkeletonValue[\App\Http\Controllers\BGenerator\WebController::NS_CLASS];
                }
            }
        }
    @endphp

    <div class="box box-{{ $fieldSetClass }}">

        @if($multipleFieldSets)
            <div class="box-header with-border">
                <h3 class="box-title">{{ $formFieldName }}</h3>
            </div>
        @endif

        <div class="box-body">
            <div class="row col-sm-10">

                @foreach($formFieldSet as $formItem)

                    @php $rawformItem = $formItem; @endphp
                    @if(substr($formItem, 0, 1) == '_')
                        @php $rawformItem = substr($formItem, 1); @endphp
                    @endif

                    @foreach($fields as $f_k => $f_v)

                        @if($f_k == $rawformItem)

                                @if(substr($formItem, 0, 1) == '_')
                                    @include($customView . ".form" . $headerItem , [
                                        'fieldName' => $f_k,
                                        'field'     => $f_v,
                                        'formItem'  => $formItem,
                                        'AGformType'  => \App\Http\Controllers\BGenerator\BaseController::NS_FORM
                                    ])
                                @else
                                    @include('admin_generator.field' , [
                                        'fieldName' => $f_k,
                                        'field'     =>  $f_v,
                                        'formItem'  => $formItem,
                                        'AGformType'  => \App\Http\Controllers\BGenerator\BaseController::NS_FORM
                                    ])
                                @endif

                        @endif

                    @endforeach
                @endforeach
            </div>
        </div>

        @if($lastFieldSet)
            <div class="box-footer">
                <div class="col-sm-10">
                    <div class="col-sm-offset-2">

                        @if(view()->exists($customView . '.form_actions'))
                            @include($customView . '.form_actions', [
                                'item'  => isset($item) ? $item : null,
                                'isNew' => isset($isNew) ? $isNew : false
                            ])
                        @else
                            @include('admin_generator_parent.form_actions', [
                                'item'  => isset($item) ? $item : null,
                                'isNew' => isset($isNew) ? $isNew : false
                            ])
                        @endif

                    </div>
                </div>
            </div>
        @endif

    </div>
@endforeach

@section("scripts")
    @parent
    @include("admin_generator.icheck_scripts")
    @include("admin_generator.datepicker_scripts")
@endsection