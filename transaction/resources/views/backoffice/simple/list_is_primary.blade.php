@if(\Illuminate\Support\Facades\App::getLocale() == "fa")
    {{ $item->is_primary ? 'بله' : 'خیر'}}
@else
    {{ $item->is_primary ? 'Yes' : 'No'}}
@endif