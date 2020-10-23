<table class="table table-bordered table-striped dataTable" id="{!! $modelName !!}-table">
    <thead>
    <tr>
        @if(sizeof($batchActions) > 0)
            <th style="width: 25px">
                <input id="list_batch_checkbox" class="square" type="checkbox" value="1"/>
            </th>
        @endif
        @foreach($headerItems as $headerItem)
            @foreach($fields as $f_k => $f_v)
                @php $rawHeaderItem = $headerItem; @endphp
                @if(substr($headerItem, 0, 1) == '_')
                    @php $rawHeaderItem = substr($headerItem, 1); @endphp
                @endif
                @if($f_k == $rawHeaderItem)

                    @php
                        $sortable = \App\Http\Controllers\BGenerator\BaseController::DEFAULT_SORTABLE;
                        if(isset($f_v[\App\Http\Controllers\BGenerator\BaseController::NS_SOTRABLE])){
                            $sortable = $f_v[\App\Http\Controllers\BGenerator\BaseController::NS_SOTRABLE];
                        }

                        $sortClass = "";
                        $ariaSortOrder = "";

                        if($sortable){
                            $sortClass = "sortable sorting";

                            if($sortField == $f_k){
                                if($sortOrder == 'asc'){
                                    $sortClass = "sortable sorting_asc";
                                    $ariaSortOrder = 'desc';
                                }else{
                                    $sortClass = "sortable sorting_desc";
                                    $ariaSortOrder = 'asc';
                                }
                            }
                        }
                    @endphp

                    <th class="{!! $sortClass !!}" aria-sort="{!! $f_k !!}" aria-sort-order="{!! $ariaSortOrder !!}">
                        {{ __($f_v['label']) }}
                    </th>
                @endif
            @endforeach
        @endforeach
        @if(sizeof($objectActions) > 0)
            <th colspan="3">{{ __('generator.operation') }}</th>
        @endif
    </tr>

    </thead>
    @if(sizeof($items) > 10)
        @if(!isset($withFooter) || $withFooter == true)
            <tfoot>
            <tr>
                @if(sizeof($batchActions) > 0)
                    <th></th>
                @endif
                @foreach($headerItems as $headerItem)
                    @foreach($fields as $f_k => $f_v)
                        @php $rawHeaderItem = $headerItem; @endphp
                        @if(substr($headerItem, 0, 1) == '_')
                            @php $rawHeaderItem = substr($headerItem, 1); @endphp
                        @endif
                        @if($f_k == $rawHeaderItem)
                            <th>{{ trans($f_v['label'] ) }}</th>
                        @endif
                    @endforeach
                @endforeach
                <th colspan="3">{{ __('generator.operation') }}</th>
            </tr>
            </tfoot>
        @endif
    @endif
    <tbody>
    @foreach($items as $item)
        <tr>
            @if(sizeof($batchActions) > 0)
                <td>
                    <input class="square batch_checkbox" type="checkbox" name="ids[]" value="{!! $item->getKey() !!}"/>
                </td>
            @endif
            @foreach($headerItems as $headerItem)
                <td>
                    @if(substr($headerItem, 0, 1) == '_')
                        @include($customView . ".list" . $headerItem, [
                            'item' => $item
                        ])
                    @else
                        {!! $item->$headerItem !!}
                    @endif
                </td>
            @endforeach
            @if(sizeof($objectActions) > 0)
                <td>
                    @if(view()->exists($customView . '.object_actions'))
                        @include($customView . '.object_actions', [
                            'item'  => $item
                        ])
                    @else
                        @include('admin_generator.object_actions', [
                            'item'  => $item
                        ])
                    @endif
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>

</table>