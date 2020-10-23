@section("scripts")
    @parent
    <script>
        $("#{!! $fieldName !!}").select2({
            placeholder: '{!! $placeholder !!}',
            allowClear: true,
            ajax: {
                delay: 250,
                url: '{!! route($dataProvider) !!}',
                data: function (params) {
                  var query = {
                    q: params.term,
                    term: params.term,
                    item: '{!! isset($item) && $item ? $item->getKey() : null !!}',
                    parent: '{!! isset($parentObject) && $parentObject ? $parentObject->getKey() : null !!}'
                  };

                  return query;
                }
            }
        })
    </script>
@endsection
@include("admin_generator.field_select")