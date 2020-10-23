@if(\App\Helpers\Util::is_set($item->from_date))
    {{ \App\Helpers\Util::i18n_date2($item->from_date, null, false, null, false, false) }}
@endif