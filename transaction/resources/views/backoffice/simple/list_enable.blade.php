@if(\Illuminate\Support\Facades\App::getLocale() == "fa")

    {{ $item->enable ? 'بله' : 'خیر'}}
@else
    {{ $item->enable ? 'Yes' : 'No'}}
@endif