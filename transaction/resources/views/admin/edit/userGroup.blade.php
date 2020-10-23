@section('content')
    <div class="col-md-12">
        @if (config('app.id') )
            {{-- Group --}}               
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input class="form-control" type="text" name="frm[title]"
                       value="{{ @$list['title'] }}" style="direction: ltr;">
            </div>
        @else
            <div class="form-group">
                @if (@$newGroups)
                    @foreach($newGroups as $key => $group)
                        <div>
                            <label>
                                <input type="checkbox" name="group[]" value="{{ $group }}" class="form-control" />
                                @lang('language.' . $group)
                            </label>
                        </div>
                    @endforeach
                @else
                    <div class="text-center">@lang('language.no new group exists') </div>
                @endif
            </div>
        @endif
    </div>
@stop