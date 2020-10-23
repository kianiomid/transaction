{{-- Uploads List --}} 
<div class="clearfix"></div>
<div class="row" style="margin-top: 15px;">      
    <div class="form-group col-md-6">
        <label class="control-label col-md-3">
            @lang('language.picture'):
        </label> 
        <div class="col-md-8">
            @var('src', '/pic/user/' . @$list['user_id'])
            @include('backend.partial.fileInput', ['exist' => @$imageExist, 'src' => $src . 'w200h150c1/' . str_random() . '.png?nocache=1', 'srcLarge' => $src . '/' . str_random() . '.png?nocache=1', 'name' => 'imageFile', 'type' => 'image', 'id' => @$list['user_id']])
        </div> 
     </div>   

    {{--<div class="form-group col-md-6">--}}
        {{--<label class="control-label col-md-3">--}}
            {{--@lang('language.signature'):--}}
        {{--</label> --}}
        {{--<div class="col-md-8">--}}
            {{--@var('srcSignature', '/pic/user.signature/' . @$list['user_id'])--}}
            {{--@include('backend.partial.fileInput', ['exist' => @$signExist, 'src' => $srcSignature . 'w200h150c1/' . str_random() . '.png?nocache=1', 'srcLarge' => $srcSignature . '/' . str_random() . '.png?nocache=1', 'name' => 'signatureFile/signature', 'type' => 'signature', 'id' => @$list['user_id']])--}}
        {{--</div> --}}
    {{--</div>--}}
</div> 