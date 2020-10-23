<!-- responsive -->
<div id="edit-{{ str_random() }}" class="@if(!Request::ajax() and @$viewEdit) @else modal fade @endif edit-responsive"  tabindex="-1" data-width="{{ @$windowWidth ? $windowWidth:  760 }}" @if (@$autoSave) data-autosave="{'periodTime': '{{ intval($autoSave) }}'}" @endif {{ @$disableESC ? 'data-keyboard="false"':  '' }} data-draggable="{{ @$draggable ? $draggable:  'true' }}" data-resizable="{{ @$resizable ? $resizable:  'false' }}" style="{{ (!Request::ajax() and @$viewEdit) ? 'margin-top: 30px;' : '' }}">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">
            @if (@$title && @!$customTitle)
                {{ __('language.edit') . ' ' . __($title) }}
            @elseif (@$customTitle)
                {!! $customTitle !!}
            @else 
                {{ ((int) config('app.id') ? t('language.edit') : t('language.create')) . ' ' . t(strtolower(config('app.controller'))) }}
            @endif
        </h4>
    </div>
    
    {!! Form::open(array('url' => Lib::getCurrentURL('controller') . '/' . (@$storeMethod ? $storeMethod:  'store') . '/' . config('app.id'), 'name' => 'frm_' . str_random(), 'id' => 'frm-' . str_random(), 'files' => true, 'target' => 'edit_frame', 'data-aftersend' => @$afterSendForm,
            'onsubmit' => (@$onSendForm ? $onSendForm:  "App.sendPopupForm(this, event, " . (@$sendOptions ? $sendOptions:  '{}'). ");") 
        )) !!}
        <div class="modal-body">
            <div class="row">
                @yield('content')
            </div>
        </div>
        @include('backend.editBtn')
    {!! Form::close() !!}

    <script type="text/javascript">
        if (typeof App != 'undefined') {
            App.validateForm($('#' + $('button.store-btn').closest('form').attr('id')));
        }
    </script>
</div>