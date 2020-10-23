<table class="list-btn">
    @php($id = @$item['xid'])
    @php($lang = config('custom.site.lang'))
	<tr>
        @if (@$customListBtn)
            @foreach($customListBtn as $kb => $btn)
                <td>
                    @if (@$item['disable'. $kb])
                        <a href="javascript:void(0);" style="cursor: default;">
                            <i class="fa {{ @$btn['fa-icon'] }}" style="color: #aaa;"></i>
                        </a>
                    @else
                        @php($url = @$btn['url'])
                        @if (@$btn['action'])
                            @php($url = Lib::getCurrentURL('controller') . '/' . $btn['action'])
                        @endif
                        <a class="tooltips" href="{{ $url . '/' . $id }}" title="{{ @$btn['title'] }}"  target="{{ @$btn['target'] }}" @if (@$btn['action']) onclick="App.call(this, {'method': '{{ @$btn['action'] }}', 'id': '{{ $id }}'}, event);" @elseif (@$btn['url']) App.call(this, {'url', "{{ @$btn['url'] }}"]}, event); @endif @if(@$btn['options']) @foreach($btn['options'] as $kop => $vop) {{ @$kop }}="{{ $vop }}" @endforeach @endif>
                            <i class="fa {{ @$btn['fa-icon'] }}"></i>
                        </a>
                    @endif
                </td>
            @endforeach
        @endif
        
		@if (!@$listBtn['hideEdit']) 
			<td>
                @if (@$item['disableEdit'] or @$item['preview'])
                    <a href="javascript:void(0);" style="cursor: default;">
                        <i class="fa fa-pencil-square-o" style="color: #aaa;"></i>
                    </a>
                @else
                    <a class="tooltips" href="{{ Lib::getCurrentURL('controller') . '/edit/' . $id }}" title="{{ trans('language.edit') }}"
                        onclick="App.call(this, {'method': 'edit', 'id': '{{ $id }}'}, event);">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>  
                @endif    
			</td>
		@endif

		@if (!@$listBtn['hideDelete']) 
			<td>
                @if (@$item['disableDelete'] or @$item['preview'])
                    <a href="javascript:void(0);" style="cursor: default;">
                        <i class="fa fa-trash" style="color: #aaa;"></i>
                    </a>
                @else 
                    <a class="tooltips" href="{{ Lib::getCurrentURL('controller') . '/delete/' . $id }}" title="{{ trans('language.remove') }}" onclick="App.call(this, {'method': 'delete', 'id': '{{ $id }}', 'result': 'iframe'}, event);">
                        <i class="fa fa-trash"></i>
                    </a>
                @endif    
			</td>
		@endif
	</tr>
</table>