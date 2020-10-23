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

                            <div class="form-group col-sm-12">
                                @php
                                    $label = $f_v[\App\Http\Controllers\BGenerator\WebController::NS_LABEL];
                                    $form = isset($f_v[\App\Http\Controllers\BGenerator\WebController::NS_FORM]) ? $f_v[\App\Http\Controllers\BGenerator\WebController::NS_FORM] : null;
                                    $formType = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_TYPE]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_TYPE] : 'text';
                                    $class = isset($form[\App\Http\Controllers\BGenerator\WebController::NS_CLASS]) ? $form[\App\Http\Controllers\BGenerator\WebController::NS_CLASS] : '';
                                @endphp
                                {!! Form::label($f_k, __($label) . ':', [
                                    'class' => 'col-sm-2 control-label'
                                ]) !!}
                                <div class="col-sm-5">
                                    @if(substr($formItem, 0, 1) == '_')
                                        @include($customView . ".show" . $formItem , [
                                            'item' => $item
                                        ])
                                    @else
                                        @if($formType == 'textarea')
                                            <textarea style="resize: vertical" class="form-control {!! $class !!}" disabled="">{!! $item->$f_k !!}</textarea>
                                        @elseif($formType == 'checkbox')
                                            <div class="state icheckbox_square-blue {{ $item->$f_k == 1 ? "checked" : "" }}"></div>
                                        @elseif($formType == 'date')
                                            <input id="{{ $f_k }}" class="form-control {!! $class !!}" disabled="" />
                                            @section("scripts")
                                                @parent
                                                @if(\App\Helpers\Util::is_set($item->$f_k))
                                                <script>
                                                    var {{ $f_k }}_unix = new Date('{!! $item->$f_k !!}').getTime();
                                                    var {{ $f_k }}_pd = new persianDate({{ $f_k }}_unix);
                                                    $("#{{ $f_k }}").val({{ $f_k }}_pd.format("D MMMM YYYY"));
                                                </script>
                                                @endif
                                            @endsection
                                        @elseif($formType == 'datetime')
                                            <input id="{{ $f_k }}" class="form-control {!! $class !!}" disabled="" />
                                            @section("scripts")
                                                @parent
                                                @if(\App\Helpers\Util::is_set($item->$f_k))
                                                <script>
                                                    var {{ $f_k }}_unix = new Date('{!! $item->$f_k !!}').getTime();
                                                    var {{ $f_k }}_pd = new persianDate({{ $f_k }}_unix);
                                                    $("#{{ $f_k }}").val({{ $f_k }}_pd.format("D MMMM YYYY HH:mm"));
                                                </script>
                                                @endif
                                            @endsection
                                        @else
                                            @if(is_iterable($item->$f_k))
                                                @php $_rs = [] @endphp
                                                @foreach($item->$f_k as $_fk)
                                                    @php $_rs[] = $_fk->__toString() @endphp
                                                @endforeach
                                                @php $itemValue = join($_rs, " ، ") @endphp
                                                <textarea style="resize: vertical" class="form-control {!! $class !!}" disabled="">{!! $itemValue !!}</textarea>
                                            @else
                                                <input class="form-control {!! $class !!}"  type="text" disabled="" value="{!! $item->$f_k !!}">
                                            @endif

                                        @endif
                                    @endif
                                </div>
                            </div>

                        @endif

                    @endforeach
                @endforeach
            </div>
        </div>

        @if($lastFieldSet)
            <div class="box-footer">
                <div class="col-sm-10">
                    <div class="col-sm-offset-2">

                        @if(view()->exists($customView . '.show_actions'))
                            @include($customView . '.show_actions', [
                                'item'  => $item
                            ])
                        @else
                            @include('admin_generator_parent.show_actions', [
                                'item'  => $item,
                            ])
                        @endif

                    </div>
                </div>
            </div>
        @endif

    </div>
@endforeach