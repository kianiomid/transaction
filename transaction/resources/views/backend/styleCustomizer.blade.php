<!-- BEGIN STYLE CUSTOMIZER -->
<div class="theme-panel hidden-xs hidden-sm">
    <div class="toggler">
    </div>
    <div class="toggler-close">
    </div>
   
    <div class="theme-options">
        <div class="theme-option theme-colors clearfix">
            <span>
                 @lang('language.theme color')
            </span>

            <ul>
                <li class="color-black @if(!@$_COOKIE['style_color'] or @$_COOKIE['style_color'] == 'default') current @endif color-default" data-style="default">
                </li>
                <li class="color-blue @if(@$_COOKIE['style_color'] == 'blue') current @endif" data-style="blue">
                </li>
                <li class="color-brown @if(@$_COOKIE['style_color'] == 'brown') current @endif" data-style="brown">
                </li>
                <li class="color-purple @if(@$_COOKIE['style_color'] == 'purple') current @endif" data-style="purple">
                </li>
                <li class="color-grey @if(@$_COOKIE['style_color'] == 'grey') current @endif" data-style="grey">
                </li>
                <li class="color-white color-light @if(@$_COOKIE['style_color'] == 'light') current @endif" data-style="light">
                </li>
            </ul>
        </div>
        <div class="theme-option">
            <span>
                 @lang('language.layout')
            </span>
            <select class="layout-option form-control input-small" data-advancedselect="{'minimumResultsForSearch': 'Infinity'}">
                <option value="fluid">@lang('language.fluid')</option>
                <option value="boxed">@lang('language.boxed')</option>
            </select>
        </div>
        <div class="theme-option">
            <span>
                 @lang('language.header')
            </span>
            <select class="header-option form-control input-small" data-advancedselect="{'minimumResultsForSearch': 'Infinity'}">
                <option value="default">@lang('language.default')</option>
                <option value="fixed">@lang('language.fixed')</option>
            </select>
        </div>
        <div class="theme-option">
            <span>
                 @lang('language.sidebar')
            </span>
            <select class="sidebar-option form-control input-small" data-advancedselect="{'minimumResultsForSearch': 'Infinity'}">
                <option value="default">@lang('language.default')</option>
                <option value="fixed">@lang('language.fixed')</option>
            </select>
        </div>
        <div class="theme-option">
            <span>
                 @lang('language.sidebar position')
            </span>
            <select class="sidebar-pos-option form-control input-small" data-advancedselect="{'minimumResultsForSearch': 'Infinity'}">
                <option value="default">@lang('language.default')</option>
                <option value="left">@lang('language.left')</option>
                <option value="right">@lang('language.right')</option>
            </select>
        </div>
        <div class="theme-option">
            <span>
                 @lang('language.footer')
            </span>
            <select class="footer-option form-control input-small" data-advancedselect="{'minimumResultsForSearch': 'Infinity'}">
                <option value="default">@lang('language.default')</option>
                <option value="fixed">@lang('language.fixed')</option>
            </select>
        </div>
    </div>
</div>
<!-- END STYLE CUSTOMIZER -->