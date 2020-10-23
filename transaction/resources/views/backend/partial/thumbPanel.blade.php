@var('color', @$color ? $color:  'blue')
@var('faIcon', @$faIcon ? $faIcon:  'fa-envelope')
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 {{ @$class }}">
    <div class="dashboard-stat {{ @$color }}">
        <div class="visual">
            <i class="fa {{ @$faIcon }}"></i>
        </div>
        <div class="details">
            <div class="number">{{ @$number ? $number:  0 }}</div>
            <div class="desc">{{ @$desc ? $desc:  '' }}</div>
        </div>
        @if (!@$hideMore)
            <a class="more" href="{{ @$link ? $link:  'javascript:void(0);' }}">
                 {{ @$moreTitle ? $moreTitle:  trans('language.view') }}
                 <i class="m-icon-white @if(config('app.dir') == 'rtl') m-icon-swapleft @else m-icon-swapright @endif"></i>
            </a>
        @endif
    </div>
</div>