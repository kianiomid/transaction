@if(\Illuminate\Support\Facades\App::getLocale() == "fa")
    {{ $item->is_admin ? 'بله' : 'خیر'}}
@else
    {{ $item->is_admin ? 'Yes' : 'No'}}
@endif