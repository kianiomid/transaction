@if(\Illuminate\Support\Facades\App::getLocale() == "fa")
    {{ \App\Helpers\Util::i18n_date2($item->end_date, \App\Models\CultureType::FA, false, null, false, false) }}
@else
    {{ \App\Helpers\Util::i18n_date2($item->end_date, \App\Models\CultureType::EN, false, null, false, false) }}
@endif