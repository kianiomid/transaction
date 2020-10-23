@var('defaultSrc', @$defaultSrc ?:  '/images/noimage.gif')
@var('action', (@$action ?:  'removeItem'))

<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-new thumbnail custom-thumbnail">
        @if (@$exist and @$href)
            <div class="fileinput-icon" style="position: relative; overflow: hidden;">
                <img class="reset" src="{{ @$src ?:  '/images/icon/pdf.png' }}" alt="" data-src="{{ @$defaultSrc }}" />
                <div class="reset">
                    @if (@$src and @$srcLarge)
                        <div class="mix-details">
                            <a href="{{ $srcLarge }}" class="mix-preview fancybox-button" title="">
                                <span class="fa fa-search"></span>
                            </a>
                        </div>
                    @endif 
                </div>
            </div>
            <div class="reset">
                <div class="mb-15">
                    @if (@$fileName)
                        <div class="ltr">{{ @$fileName }}</div>
                    @endif 
                    @if (@$fileSize)
                        <div>({{ FarsiLib::convertDigit(@$fileSize) }} @lang('language.kb'))</div>
                    @endif
                </div>
                <div>
                    <a class="btn btn-info btn-block" href="{{ $href }}" >
                        <span class="fa fa-download"></span>
                        @lang('language.download')
                    </a>
                </div>
            </div>
        @elseif (@$exist and @$src)
            <div class="fileinput-icon" style="position: relative; overflow: hidden;">
                <img class="reset" src="{{ $src }}" alt="" data-src="{{ @$defaultSrc }}"/>
                @if (@$srcLarge)
                    <div class="mix-details">
                        <a href="{{ $srcLarge }}" class="mix-preview fancybox-button" title="">
                            <span class="fa fa-search"></span>
                        </a>
                    </div>
                @endif    
            </div>
        @else
            <img src="{{ @$defaultSrc ?: (@$href ? '/images/icon/unknown.png': '/images/no-image.jpg') }}" alt="" />
        @endif
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail reset" style="width: 200px; max-height: 150px;"
        @if (@$href) data-icon="{{ @$src ?:  '/images/icon/unknown.png' }}" @elseif (@$defaultSrc and @$src) data-icon="{{ $defaultSrc }}" @endif data-reseticon="{{ $defaultSrc }}">
    </div>
    
    @if (!@$previewMode)
        <div>
            <span class="btn btn-primary btn-file @if(config('app.dir') == 'ltr' && !@$fileGallery) pull-right @endif" >
                <span class="fileinput-new">@lang('language.browse') </span>
                <span class="fileinput-exists">@lang('language.browse') </span>
                <input type="file" name="{{ $name ?: 'file' }}" @if(@$options) @foreach($options as $k => $v) {{ @$k }}="{{ $v }}" @endforeach @endif >
            </span>
            <a href="#" class="btn default fileinput-exists" data-dismiss="fileinput">
                @lang('language.refuse') 
            </a>
            @if (@$exist)
                @if (@$href) 
                    @var('action', 'deleteFile')
                @endif
                
                @if (!@$hideRemove and !@$fileGallery)
                    <a href="{{ getCurrentURL('controller') . '/' . $action  . '/' . @$id }}" onclick="App.removeFile(this, event, '{{ @$type }}');" class="btn btn-danger fileinput-remove @if (config('app.dir') == 'rtl') pull-right @else pull-left @endif ">
                        <span class="fa fa-trash-o"></span>
                        @lang('language.remove')
                    </a>
                @endif
            @endif
        </div>
    @endif    
</div> 

@if (@$fileGallery and !@$previewMode)
    @var('duplicateClass', @$duplicateClass ?: 'item-list')
    <div class="btn-gallery">
        <a class="reset remBut rem" style="padding: 0;" target="edit_frame" onclick="App.removeRow(this, '{{ $duplicateClass }}', event);"
           href="{{ (int) @$id ? getCurrentURL('controller') . '/' . @$action . '/' . @$id : 'javascript:void(0);' }}">
            <span class="fa fa-trash"></span>
        </a>
        <a class="addBut" style="padding: 0;" href="javascript:void(0)" onclick="App.duplicateRow('{{ $duplicateClass }}');">
            <span class="fa fa-plus-square"></span>
        </a>
    </div>
@endif