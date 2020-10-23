@if(\App\Helpers\Util::is_set($item->date_time) && \Illuminate\Support\Facades\App::getLocale() == "fa")
    {{ \App\Helpers\Util::i18n_date2($item->date_time, \App\Models\CultureType::FA, false, null, false, false) }}
@else
    {{ \App\Helpers\Util::i18n_date2($item->date_time, \App\Models\CultureType::EN, false, null, false, false) }}
@endif