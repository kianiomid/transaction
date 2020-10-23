<!doctype html>
<html lang="en">
<head>
    @include('backend._head')
</head>
<body class="page-header-fixed">
    @include('backend.header')
    <div class="page-container">
        @include('backend.sidebar')
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                    @include('backend.styleCustomizer')
                  
                    @if (!@$hideBreadcrumb)
                        @include('backend.breadcrumb')
                    @endif

                    @if (@$custom)
                        @if (!Request::ajax() and @$viewEdit)                        
                        @else 
                            @yield('content')
                        @endif    
                    @else
                        <div class="row">
                            <div class="col-md-12">
                               <!-- BEGIN TABLE PORTLET-->
                                <form class="portlet-form" action="{{ Lib::getCurrentURL('controller') }}" onsubmit="return false;">
                                    <div class="portlet box blue-hoki">
                                        @include('backend.toolbar')
                                        <div class="portlet-body">
                                                @include('backend.search')
                                            <div class="table-responsive data-list content-data-list">
                                                @yield('content')
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END TABLE PORTLET-->
                            </div>
                        </div>
                    @endif
                    
                    <div class="edit-window">
                        @if (!@$custom or @$viewEdit)
                            @include('backend.edit')
                        @endif
                    </div>
                    
                    <iframe id="edit_frame" class="edit-frame" name="edit_frame" src="" frameborder="0" height="250" 
                        width="100%" scrolling="no">
                    </iframe>
                </div>
            </div>
            <!-- END CONTENT -->            
    </div>
    @include('backend.footer')
    @include('backend.assets')
</body>
</html>