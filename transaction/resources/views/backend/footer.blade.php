
@if (strtolower(config('app.controller')) == 'auth')
    <!-- BEGIN COPYRIGHT  Login -->
    <div class="copyright">
        {{ date('Y') }} &copy;
        <div class="footer-inner">{{ date('Y') }} &copy; @lang('label.custom')</div>

    </div>
@else
    <!-- BEGIN FOOTER -->
    <div class="footer">

        <div class="footer-inner">{{ date('Y') }} &copy; @lang('label.custom')</div>
        <div class="footer-tools">
            <span class="go-top">
                <i class="fa fa-angle-up"></i>
            </span>
        </div>
    </div>
    <!-- END FOOTER -->
@endif