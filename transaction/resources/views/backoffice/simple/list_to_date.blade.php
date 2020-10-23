@if(\App\Helpers\Util::is_set($item->to_date))
    {{ \App\Helpers\Util::i18n_date2($item->to_date, null, false, null, false, false) }}
@endif