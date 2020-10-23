
@if(@$tplsearch)
    <div class="search-box table-responsive" style="display: none;">
        @include($tplsearch)
        <div class="search-btn-list pull-right">
            <input class="btn btn-default btn-show-all" type="reset" value="{{ trans('language.reset form') }}" />

            <button type="submit" class="btn btn-default blue" type="button" onclick="App.list({search:  true});" >
                {{ trans('language.search') }}&nbsp;&nbsp;<i class="fa fa-search"></i>
            </button>

        </div>
        <div class="clearfix"></div>
    </div>
    <script type="text/javascript">
        $('.search-box .btn-show-all').off('click').click(function() {
            var portlet = $(this).closest('.portlet-body');
            portlet.find('[data-advancedselect]').select2('val', '');
            portlet.find('.checker span').removeClass('checked');
            portlet.find('.reset:hidden').val('');
            portlet.find('label.btn').removeClass('active');
            setTimeout(App.list, 10);
        });
    </script>
@endif