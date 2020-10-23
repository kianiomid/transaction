@if (@$userList) 
    @foreach ($userList as $user)
        <div class="col-md-6 col-xs-12 form-body">
            <div>
                <i class="fa fa-circle tooltips" title="{{ trans('language.' . $user['status']) }}" style="color: {{ ($user['status'] == 'online' ? '#28b779':  ($user['status'] == 'idle' ? '#ffb848':  '#e02222;')) }}; cursor: default;"></i>
                @if ($user['imageexist'])
                    <img src="/pic/user/{{ $user['user_id'] }}w32h40c1/{{ str_random() . '.jpg?nocache=1' }}" style="width: 32px;height: 40px;" alt="">
                @else
                    <img src="/assets/plugins/metronic/img/avatar.png" style="height: 40px;" alt="" />
                @endif
                {{ $user['xuser_fullname'] }}
            </div>    
        </div>    
    @endforeach
    <div class="clearfix"></div>
@endif