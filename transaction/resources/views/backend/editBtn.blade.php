<div class="modal-footer form-actions">
    @if (@$customEditBtn)
        @foreach($customEditBtn as $kb => $btn)
            <button type="{{ @$btn['type'] ?: 'submit' }}" @if(@$btn['options']) @foreach($btn['options'] as $kop => $vop) {{ e(@$kop) }}="{{ e($vop) }}" @endforeach @endif>
            	@if (@$btn['fa-icon'])
                	<i class="fa {{ @$btn['fa-icon'] }}"></i>
                @endif
                {{ @$btn['title'] }}
            </button>  
        @endforeach
    @endif

    @if (@!$editBtn['hideSubmit'])
    	<button type="submit" name="submitForm" class="btn btn-primary store-btn" onclick="return {!! (@$store ? $store : 'true') !!};">
    		<i class="fa fa-save"></i>
    		@lang('language.submit')
    	</button> 
    @endif

</div>