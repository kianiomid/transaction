@extends('layouts.backoffice')

@section('content')
    <section class="content-header">

        @if(\Illuminate\Support\Facades\App::getLocale() == 'fa')

            <h1 class="pull-right admin-list-h1">{{ __($title, [
                    'parent'    =>  $parentObject
            ]) }}</h1>
            <h1 class="pull-left admin-list-actions">
                @if(view()->exists($customView . '.list_actions'))
                    @include($customView . '.list_actions')
                @else
                    @include('admin_generator_parent.list_actions')
                @endif
            </h1>

        @else
            <h1 class="pull-left admin-list-h1">{{ __($title, [
                                'parent'    =>  $parentObject
            ]) }} </h1>
            <h1 class="pull-right admin-list-actions">
                @if(view()->exists($customView . '.list_actions'))
                    @include($customView . '.list_actions')
                @else
                    @include('admin_generator_parent.list_actions')
                @endif
            </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @if(sizeof($items) > 0)
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('admin_generator.table')
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        @include('admin_generator_parent.list_batch_actions')
                        {{ $items->links('admin_generator.pagination') }}
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-sm-12">
                            {!! __('generator.item_not_found') !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include("admin_generator_parent.filters")
    <div class="clearfix"></div>
@endsection

@section('scripts')
    @parent
    @include("admin_generator.icheck_scripts")

    <script>
        $(document).ready(function(){

            $("#list_batch_checkbox").on('ifChanged', function (event) {
                if(this.checked){
                    $(".batch_checkbox").iCheck('check');
                }else{
                    $(".batch_checkbox").iCheck('uncheck');
                }
            });

        });

        $(".dataTable th").unbind('click');
        $(".dataTable th.sortable").click(function(){
            window.location.href = "{{ route($modelName . '.index', ['pid' => $parentObject->$parentRelatedKey]) }}?sort=" + $(this).attr('aria-sort') + "&sortOrder=" + $(this).attr('aria-sort-order');
        });
    </script>
@endsection