@var('name', @$name ? $name:  'status')

@if (@$list)
    <div class="btn-group" data-toggle="buttons">
        @foreach($list as $val)
            <label class="btn btn-default {{ ((@$selected == $val and !@$search) ? 'active':  '') }}" style="margin-top: 0;">
                {!! Form::radio($name, $val, ((@$selected == $val and !@$search) ? 1:  0), ['class' => 'toggle']) !!}
                @if (@$noTrans)
                    {{ $val }}
                @else
                    @lang((@$lang ? $lang : env('APP_LANG_PREFIX')) . '.' . $val)
                @endif
            </label>
        @endforeach
    </div>
@endif     