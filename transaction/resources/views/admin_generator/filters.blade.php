@if(sizeof($filterItems) > 0)
<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('generator.filter') }}</h3>
        </div>
        <form class="form-horizontal" method="post" action="{{ route($modelName . '.filter') }}">
            @include("admin_generator.filters_form")
            <div class="box-footer">

                <div class="col-sm-12">
                    <div class="col-sm-offset-4">
                        {!! Form::submit(__('generator.apply_filter'), ['class' => 'btn btn-info', 'name' => 'save']) !!}
                        <a href="{!! route($modelName.'.index') !!}?_reset=1" class="btn btn-default">{{ __('generator.reset_filter') }}</a>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endif