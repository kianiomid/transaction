<div class="col-sm-3">
    @if(sizeof($batchActions) > 0)
    <select name="batch" id="batch" class="form-control">
        <option value="">{!! __('generator.select_batch_action') !!}</option>
        @foreach($batchActions as $actionKey => $action)
            <option value="{!! $actionKey !!}">{!! __($action[\App\Http\Controllers\BGenerator\BaseController::NS_LABEL]) !!}</option>
        @endforeach
    </select>
    <button id="batchSubmit" class="btn btn-primary">{!! __("generator.go") !!}</button>
    @section("scripts")
        @parent
        <script>
            $(document).ready(function(){
                $("#batchSubmit").click(function(){

                    var action = $("#batch").val();
                    if(action == 'batchDelete'){
                        if(confirm('{{ __('generator.are_you_sure') }}') == false){
                            return false;
                        }
                    }

                    var form = $('<form method="post" action="{{ route($modelName . ".batchAction") }}"></form>');
                    $('<input />')
                        .attr("type", "hidden")
                        .attr("name", "_token")
                        .attr("value", '{{ csrf_token() }}')
                        .appendTo(form);

                    $('<input />')
                        .attr("type", "hidden")
                        .attr("name", "ids")
                        .attr("value", $("input[name='ids[]']:checked:enabled").map(function(){return $(this).val();}).get())
                        .appendTo(form);

                    $('<input />')
                        .attr("type", "hidden")
                        .attr("name", "batchAction")
                        .attr("value", action)
                        .appendTo(form);

                    form.appendTo("body").submit();

                });
            });
        </script>
    @endsection
    @endif
</div>