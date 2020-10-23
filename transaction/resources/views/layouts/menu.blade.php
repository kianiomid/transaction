@php $prefix = "Admin/" @endphp

<li class="header">{{ __('label.menu') }}</li>
{{--<li class="header">{{ \Illuminate\Support\Facades\Lang::get('generator.منو') }}</li>--}}
@php
    $routeArray = app('request')->route()->getAction();
    $routeArray = app('request')->route()->getAction();
    $controllerAction = class_basename($routeArray['controller']);
    list($controller, $action) = explode('@', $controllerAction) ;
    $controller = str_replace("Controller", "", $controller);
@endphp

{{--User Management--}}
<li class="treeview {{ in_array($controller, ['User', 'UserAccountSetting', 'UserBalanceLog', 'UserGatewayLog', 'Country', 'Currency']) ? 'active' : '' }}">

    <a href="#">
        <i class="fa fa-users"></i>
        <span>{{ __("label.management") }}</span>
        <span class="pull-left-container">
            @if(\Illuminate\Support\Facades\App::getLocale() == "fa")
                <i class="fa fa-angle-left pull-left"></i>
            @else
                <i class="fa fa-angle-right pull-right"></i>
            @endif
       </span>
    </a>

    <ul class="treeview-menu">

        {{--user--}}
        <li class="{{ $controller == 'User' ? 'active' : '' }}">
            <a href="{!! route('User.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.users") }}</span>
            </a>
        </li>

        {{--user account setting--}}
        <li class="{{ $controller == 'UserAccountSetting' ? 'active' : '' }}">
            <a href="{!! route('UserAccountSetting.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.user_account_settings") }}</span>
            </a>
        </li>

        {{--user balance log--}}
        <li class="{{ $controller == 'UserBalanceLog' ? 'active' : '' }}">
            <a href="{!! route('UserBalanceLog.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.user_balance_logs") }}</span>
            </a>
        </li>

        {{--user gateway log--}}
        <li class="{{ $controller == 'UserGatewayLog' ? 'active' : '' }}">
            <a href="{!! route('UserGatewayLog.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.user_gateway_logs") }}</span>
            </a>
        </li>

        {{--country--}}
        <li class="{{ $controller == 'Country' ? 'active' : '' }}">
            <a href="{!! route('Country.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.country") }}</span>
            </a>
        </li>

        {{--currency--}}
        <li class="{{ $controller == 'Currency' ? 'active' : '' }}">
            <a href="{!! route('Currency.index') !!}">
                <i class="fa fa-users text-green"></i>
                <span>{{ __("label.currency") }}</span>
            </a>
        </li>

    </ul>
</li>